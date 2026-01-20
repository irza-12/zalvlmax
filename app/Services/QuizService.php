<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\QuizSession;
use App\Models\QuizProgress;
use App\Models\Result;
use App\Models\QuizLeaderboard;
use App\Models\User;
use App\Models\Answer;
use App\Models\ActivityLog;
use Illuminate\Support\Str;

class QuizService
{
    /**
     * Start a new quiz session for a user.
     */
    public function startQuiz(Quiz $quiz, User $user): QuizSession
    {
        // Check if user can attempt
        if (!$quiz->canAttempt($user)) {
            throw new \Exception('Anda tidak dapat mengerjakan kuis ini.');
        }

        // Check for existing active session
        $existingSession = $quiz->getActiveSession($user);
        if ($existingSession) {
            return $existingSession;
        }

        // Calculate attempt number
        $attemptNumber = $quiz->sessions()
            ->where('user_id', $user->id)
            ->count() + 1;

        // Create new session
        $session = QuizSession::create([
            'uuid' => Str::uuid(),
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'attempt_number' => $attemptNumber,
            'started_at' => now(),
            'expires_at' => now()->addMinutes($quiz->duration),
            'status' => 'in_progress',
            'current_question_index' => 0,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Initialize progress for all questions
        $questions = $quiz->questions;
        if ($quiz->shuffle_questions) {
            $questions = $questions->shuffle();
        }

        foreach ($questions as $index => $question) {
            QuizProgress::create([
                'session_id' => $session->id,
                'question_id' => $question->id,
                'status' => $index === 0 ? 'visited' : 'not_visited',
                'visited_at' => $index === 0 ? now() : null,
            ]);
        }

        // Log activity
        ActivityLog::log(
            ActivityLog::ACTION_QUIZ_STARTED,
            "Memulai kuis: {$quiz->title}",
            $session
        );

        return $session;
    }

    /**
     * Submit an answer for a question.
     */
    public function submitAnswer(QuizSession $session, int $questionId, $answer): bool
    {
        // Verify session is still active
        if (!$session->isInProgress() || $session->isExpired()) {
            throw new \Exception('Sesi kuis sudah berakhir.');
        }

        $question = $session->quiz->questions()->find($questionId);
        if (!$question) {
            throw new \Exception('Soal tidak ditemukan.');
        }

        // Get or create progress
        $progress = QuizProgress::firstOrCreate(
            [
                'session_id' => $session->id,
                'question_id' => $questionId,
            ],
            [
                'status' => 'visited',
                'visited_at' => now(),
            ]
        );

        // Process answer based on question type
        $isCorrect = false;
        $scoreObtained = 0;
        $optionId = null;
        $selectedOptions = null;
        $essayAnswer = null;

        switch ($question->type) {
            case 'multiple_choice':
            case 'true_false':
                $optionId = $answer;
                $option = $question->options()->find($optionId);
                if ($option && $option->is_correct) {
                    $isCorrect = true;
                    $scoreObtained = $question->score;
                } else {
                    $scoreObtained = -$question->negative_score;
                }
                break;

            case 'multiple_correct':
                $selectedOptions = is_array($answer) ? $answer : [$answer];
                $correctOptions = $question->options()->where('is_correct', true)->pluck('id')->toArray();
                if (
                    count(array_diff($selectedOptions, $correctOptions)) === 0 &&
                    count(array_diff($correctOptions, $selectedOptions)) === 0
                ) {
                    $isCorrect = true;
                    $scoreObtained = $question->score;
                }
                break;

            case 'essay':
            case 'fill_blank':
                $essayAnswer = $answer;
                // Essay answers need manual review
                $isCorrect = null;
                break;
        }

        // Save or update answer
        Answer::updateOrCreate(
            [
                'session_id' => $session->id,
                'question_id' => $questionId,
            ],
            [
                'user_id' => $session->user_id,
                'option_id' => $optionId,
                'selected_options' => $selectedOptions ? json_encode($selectedOptions) : null,
                'essay_answer' => $essayAnswer,
                'is_correct' => $isCorrect,
                'score_obtained' => max(0, $scoreObtained),
                'answered_at' => now(),
            ]
        );

        // Update progress
        $progress->markAsAnswered();

        return true;
    }

    /**
     * Complete a quiz session and calculate results.
     */
    public function completeQuiz(QuizSession $session): Result
    {
        if ($session->status === 'completed') {
            return $session->result;
        }

        $quiz = $session->quiz;
        $answers = $session->answers;

        // Calculate scores
        $totalScore = $answers->sum('score_obtained');
        $maxScore = $quiz->questions->sum('score');
        $percentage = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;

        $correctAnswers = $answers->where('is_correct', true)->count();
        $wrongAnswers = $answers->where('is_correct', false)->count();
        $unanswered = $quiz->questions->count() - $answers->count();

        $completionTime = $session->started_at->diffInSeconds(now());
        $isPassed = $percentage >= $quiz->passing_score;

        // Create result
        $result = Result::create([
            'session_id' => $session->id,
            'user_id' => $session->user_id,
            'quiz_id' => $quiz->id,
            'total_score' => $totalScore,
            'max_score' => $maxScore,
            'percentage' => round($percentage, 2),
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'unanswered' => $unanswered,
            'total_questions' => $quiz->questions->count(),
            'completion_time' => $completionTime,
            'started_at' => $session->started_at,
            'completed_at' => now(),
            'is_passed' => $isPassed,
        ]);

        // Mark session as completed
        $session->markAsCompleted();

        // Update leaderboard
        QuizLeaderboard::recalculate($quiz->id);

        // Update rank for this result
        $rank = QuizLeaderboard::getUserRank($quiz->id, $session->user_id);
        if ($rank) {
            $result->update(['rank' => $rank]);
        }

        // Log activity
        ActivityLog::log(
            ActivityLog::ACTION_QUIZ_COMPLETED,
            "Menyelesaikan kuis: {$quiz->title} dengan nilai {$percentage}%",
            $session
        );

        return $result;
    }

    /**
     * Calculate quiz result for a user (legacy support)
     */
    public function calculateResult(User $user, Quiz $quiz, int $completionTime = null): Result
    {
        $questions = $quiz->questions;
        $totalQuestions = $questions->count();
        $maxScore = $questions->sum('score');

        // Find the user's session for this quiz (for proper linking)
        $session = QuizSession::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->latest('started_at')
            ->first();

        $answers = Answer::where('user_id', $user->id)
            ->whereHas('question', function ($query) use ($quiz) {
                $query->where('quiz_id', $quiz->id);
            })
            ->with(['question', 'option'])
            ->get();

        $totalScore = 0;
        $correctAnswers = 0;
        $wrongAnswers = 0;

        foreach ($answers as $answer) {
            if ($answer->isCorrect()) {
                $totalScore += $answer->question->score;
                $correctAnswers++;
            } else {
                $wrongAnswers++;
            }
        }

        $unanswered = max(0, $totalQuestions - $answers->count());
        $percentage = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;
        $isPassed = $percentage >= $quiz->passing_score;

        // Create or update result with session_id linked
        $result = Result::updateOrCreate(
            [
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
            ],
            [
                'session_id' => $session ? $session->id : null,
                'total_score' => $totalScore,
                'max_score' => $maxScore,
                'percentage' => round($percentage, 2),
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'unanswered' => $unanswered,
                'total_questions' => $totalQuestions,
                'completion_time' => $completionTime,
                'started_at' => $session ? $session->started_at : null,
                'completed_at' => now(),
                'is_passed' => $isPassed,
            ]
        );

        // Recalculate leaderboard after result is created/updated
        QuizLeaderboard::recalculate($quiz->id);

        // Update rank for this result
        $rank = QuizLeaderboard::getUserRank($quiz->id, $user->id);
        if ($rank) {
            $result->update(['rank' => $rank]);
        }

        return $result;
    }

    /**
     * Get leaderboard for a quiz
     */
    public function getLeaderboard(Quiz $quiz, int $limit = 10): array
    {
        $leaderboard = QuizLeaderboard::getTopN($quiz->id, $limit);

        if ($leaderboard->isEmpty()) {
            // Fallback to Results table if leaderboard is empty
            $results = Result::where('quiz_id', $quiz->id)
                ->with('user')
                ->orderBy('total_score', 'desc')
                ->orderBy('completion_time', 'asc')
                ->limit($limit)
                ->get();

            return $results->map(function ($result, $index) {
                return [
                    'rank' => $index + 1,
                    'rank_display' => ($index + 1) . ($index === 0 ? 'st' : ($index === 1 ? 'nd' : ($index === 2 ? 'rd' : 'th'))),
                    'user' => [
                        'id' => $result->user->id,
                        'name' => $result->user->name,
                        'avatar' => $result->user->avatar_url,
                    ],
                    'score' => $result->total_score,
                    'completion_time' => $result->completion_time,
                    'formatted_time' => $this->formatTime($result->completion_time),
                    'session_id' => $result->session_id,
                ];
            })->toArray();
        }

        return $leaderboard->map(function ($entry) {
            // Get session_id from the linked result, or find it directly
            $sessionId = $entry->result->session_id ?? null;
            if (!$sessionId && $entry->result) {
                // Try to find session from quiz_sessions table
                $session = QuizSession::where('user_id', $entry->user_id)
                    ->where('quiz_id', $entry->quiz_id)
                    ->latest('started_at')
                    ->first();
                $sessionId = $session ? $session->id : null;
            }

            return [
                'rank' => $entry->rank,
                'rank_display' => $entry->rank_display,
                'user' => [
                    'id' => $entry->user->id,
                    'name' => $entry->user->name,
                    'avatar' => $entry->user->avatar_url,
                ],
                'score' => $entry->total_score,
                'completion_time' => $entry->completion_time,
                'formatted_time' => $entry->formatted_time,
                'session_id' => $sessionId,
            ];
        })->toArray();
    }

    /**
     * Get all leaderboard (global)
     */
    public function getGlobalLeaderboard(int $limit = 10)
    {
        return Result::with(['user', 'quiz'])
            ->selectRaw('user_id, SUM(total_score) as total_score, COUNT(*) as quiz_count')
            ->groupBy('user_id')
            ->orderBy('total_score', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get real-time progress data for monitoring.
     */
    public function getRealtimeProgress(Quiz $quiz): array
    {
        $activeSessions = $quiz->sessions()
            ->where('status', 'in_progress')
            ->with(['user:id,name,avatar', 'progress'])
            ->get();

        $progressData = [];

        foreach ($activeSessions as $session) {
            $totalQuestions = $quiz->questions->count();
            $answeredCount = $session->progress->where('status', 'answered')->count();
            $skippedCount = $session->progress->where('status', 'skipped')->count();
            $notVisitedCount = $session->progress->where('status', 'not_visited')->count();
            $markedCount = $session->progress->where('status', 'marked_review')->count();

            $progressData[] = [
                'session_id' => $session->id,
                'user' => [
                    'id' => $session->user->id,
                    'name' => $session->user->name,
                    'avatar' => $session->user->avatar_url,
                ],
                'started_at' => $session->started_at->toISOString(),
                'elapsed_time' => $session->elapsed_time,
                'remaining_time' => $session->remaining_time,
                'total_questions' => $totalQuestions,
                'answered' => $answeredCount,
                'skipped' => $skippedCount,
                'not_visited' => $notVisitedCount,
                'marked_review' => $markedCount,
                'progress_percentage' => $session->progress_percentage,
                'current_question' => $session->current_question_index + 1,
            ];
        }

        return [
            'quiz_id' => $quiz->id,
            'quiz_title' => $quiz->title,
            'active_users' => count($progressData),
            'sessions' => $progressData,
            'updated_at' => now()->toISOString(),
        ];
    }

    /**
     * Get statistics for a quiz.
     */
    public function getQuizStatistics(Quiz $quiz): array
    {
        $results = $quiz->results()->whereNotNull('completed_at');

        $avgScore = $results->avg('percentage') ?? 0;
        $highestScore = $results->max('percentage') ?? 0;
        $lowestScore = $results->min('percentage') ?? 0;
        $avgTime = $results->avg('completion_time') ?? 0;
        $passedCount = $results->clone()->where('is_passed', true)->count();
        $totalAttempts = $results->count();
        $passRate = $totalAttempts > 0 ? ($passedCount / $totalAttempts) * 100 : 0;

        // Question difficulty analysis
        $questionStats = [];
        foreach ($quiz->questions as $question) {
            $answers = $question->answers()->whereNotNull('is_correct');
            $totalAnswers = $answers->count();
            $correctCount = $answers->clone()->where('is_correct', true)->count();
            $correctRate = $totalAnswers > 0 ? ($correctCount / $totalAnswers) * 100 : 0;

            $questionStats[] = [
                'question_id' => $question->id,
                'question_text' => substr($question->question_text, 0, 100) . '...',
                'total_answers' => $totalAnswers,
                'correct_count' => $correctCount,
                'correct_rate' => round($correctRate, 1),
                'difficulty' => $correctRate >= 70 ? 'easy' : ($correctRate >= 40 ? 'medium' : 'hard'),
            ];
        }

        // Score distribution
        $scoreDistribution = [
            '0-20' => $quiz->results()->whereBetween('percentage', [0, 20])->count(),
            '21-40' => $quiz->results()->whereBetween('percentage', [21, 40])->count(),
            '41-60' => $quiz->results()->whereBetween('percentage', [41, 60])->count(),
            '61-80' => $quiz->results()->whereBetween('percentage', [61, 80])->count(),
            '81-100' => $quiz->results()->whereBetween('percentage', [81, 100])->count(),
        ];

        return [
            'quiz_id' => $quiz->id,
            'quiz_title' => $quiz->title,
            'summary' => [
                'total_attempts' => $totalAttempts,
                'passed_count' => $passedCount,
                'pass_rate' => round($passRate, 1),
                'avg_score' => round($avgScore, 1),
                'highest_score' => round($highestScore, 1),
                'lowest_score' => round($lowestScore, 1),
                'avg_completion_time' => round($avgTime),
            ],
            'score_distribution' => $scoreDistribution,
            'question_analysis' => $questionStats,
        ];
    }

    /**
     * Check if user has already taken the quiz
     */
    public function hasUserTakenQuiz(User $user, Quiz $quiz): bool
    {
        return Result::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->whereNotNull('completion_time')
            ->exists();
    }

    /**
     * Get user's quiz progress
     */
    public function getUserProgress(User $user, Quiz $quiz)
    {
        $totalQuestions = $quiz->questions()->count();
        $answeredQuestions = Answer::where('user_id', $user->id)
            ->whereHas('question', function ($query) use ($quiz) {
                $query->where('quiz_id', $quiz->id);
            })
            ->distinct('question_id')
            ->count('question_id');

        return [
            'total' => $totalQuestions,
            'answered' => $answeredQuestions,
            'remaining' => $totalQuestions - $answeredQuestions,
            'percentage' => $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100, 2) : 0,
        ];
    }

    /**
     * Delete user's answers for a quiz (for retake)
     */
    public function resetQuizAttempt(User $user, Quiz $quiz): void
    {
        Answer::where('user_id', $user->id)
            ->whereHas('question', function ($query) use ($quiz) {
                $query->where('quiz_id', $quiz->id);
            })
            ->delete();

        Result::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->delete();
    }

    /**
     * Format time in seconds to readable format.
     */
    private function formatTime(?int $seconds): string
    {
        if (!$seconds)
            return '0 detik';

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        if ($minutes > 0) {
            return sprintf('%d:%02d', $minutes, $remainingSeconds);
        }

        return sprintf('%d detik', $remainingSeconds);
    }
}

