<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Answer;
use App\Models\Result;

class QuizService
{
    /**
     * Calculate quiz result for a user
     */
    public function calculateResult(User $user, Quiz $quiz, int $completionTime = null): Result
    {
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

        // Create or update result
        $result = Result::updateOrCreate(
            [
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
            ],
            [
                'total_score' => $totalScore,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'completion_time' => $completionTime,
            ]
        );

        return $result;
    }

    /**
     * Get leaderboard for a quiz
     */
    public function getLeaderboard(Quiz $quiz, int $limit = 10)
    {
        return Result::where('quiz_id', $quiz->id)
            ->with('user')
            ->orderBy('total_score', 'desc')
            ->orderBy('completion_time', 'asc')
            ->limit($limit)
            ->get();
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
}
