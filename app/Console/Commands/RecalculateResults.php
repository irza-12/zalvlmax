<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Result;
use App\Models\QuizSession;
use App\Models\Quiz;
use App\Models\Answer;

class RecalculateResults extends Command
{
    protected $signature = 'results:recalculate {--quiz= : Quiz ID to recalculate}';
    protected $description = 'Recalculate all results with proper percentage and is_passed values';

    public function handle()
    {
        $this->info('=== Step 1: Fixing Answers is_correct field ===');

        // First, fix all answers that have null is_correct
        $answers = Answer::with('option')->whereNull('is_correct')->get();
        $fixedAnswers = 0;

        foreach ($answers as $answer) {
            if ($answer->option) {
                $isCorrect = (bool) $answer->option->is_correct;
                $scoreObtained = $isCorrect ? ($answer->question->score ?? 5) : 0;

                $answer->update([
                    'is_correct' => $isCorrect,
                    'score_obtained' => $scoreObtained,
                ]);
                $fixedAnswers++;
            }
        }

        $this->info("Fixed {$fixedAnswers} answers with is_correct values");

        $this->info("\n=== Step 2: Recalculating Results ===");

        // Now recalculate all results
        $results = Result::with(['session.answers.option', 'quiz.questions', 'user'])->get();

        $fixed = 0;
        $skipped = 0;

        foreach ($results as $result) {
            $quiz = $result->quiz;

            if (!$quiz) {
                $this->warn("Result #{$result->id}: No quiz found, skipping.");
                $skipped++;
                continue;
            }

            // Get total questions and calculate scores
            $totalQuestions = $quiz->questions->count();
            $scorePerQuestion = $quiz->questions->first()?->score ?? 5;
            $maxScore = $totalQuestions * $scorePerQuestion;

            if ($maxScore == 0) {
                $maxScore = $totalQuestions * 5;
            }

            // Get answers - try from session first, then from user directly
            $correctAnswers = 0;
            $wrongAnswers = 0;
            $totalScore = 0;

            if ($result->session_id && $result->session) {
                // Use session answers
                $sessionAnswers = $result->session->answers()->with('option')->get();

                foreach ($sessionAnswers as $answer) {
                    $isCorrect = $answer->option && $answer->option->is_correct;
                    if ($isCorrect) {
                        $correctAnswers++;
                        $totalScore += $scorePerQuestion;
                    } else {
                        $wrongAnswers++;
                    }
                }
            } else {
                // Use user answers directly (old data format)
                $userAnswers = Answer::where('user_id', $result->user_id)
                    ->whereHas('question', function ($q) use ($quiz) {
                        $q->where('quiz_id', $quiz->id);
                    })
                    ->with('option')
                    ->get();

                foreach ($userAnswers as $answer) {
                    $isCorrect = $answer->option && $answer->option->is_correct;
                    if ($isCorrect) {
                        $correctAnswers++;
                        $totalScore += $scorePerQuestion;
                    } else {
                        $wrongAnswers++;
                    }
                }
            }

            // Calculate percentage
            $percentage = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;
            $percentage = min(100, round($percentage, 2));

            // Determine is_passed
            $passingScore = $quiz->passing_score ?? 70;
            $isPassed = $percentage >= $passingScore;

            $unanswered = $totalQuestions - $correctAnswers - $wrongAnswers;

            // Check if we need to update
            $needsUpdate = ($result->percentage != $percentage) ||
                ($result->is_passed != $isPassed) ||
                ($result->correct_answers != $correctAnswers) ||
                ($result->max_score != $maxScore);

            if ($needsUpdate) {
                $oldPercentage = $result->percentage;
                $oldIsPassed = $result->is_passed ? 'YES' : 'NO';

                $result->update([
                    'max_score' => $maxScore,
                    'total_score' => $totalScore,
                    'percentage' => $percentage,
                    'correct_answers' => $correctAnswers,
                    'wrong_answers' => $wrongAnswers,
                    'unanswered' => max(0, $unanswered),
                    'total_questions' => $totalQuestions,
                    'is_passed' => $isPassed,
                ]);

                $newIsPassed = $isPassed ? 'YES' : 'NO';
                $userName = $result->user ? $result->user->name : 'Unknown';
                $this->info("Result #{$result->id} ({$userName}): {$oldPercentage}% -> {$percentage}%, Correct: {$correctAnswers}/{$totalQuestions}, is_passed: {$oldIsPassed} -> {$newIsPassed}");
                $fixed++;
            } else {
                $skipped++;
            }
        }

        $this->info("\nRecalculation done! Fixed: {$fixed}, Skipped: {$skipped}");

        // Also check for completed sessions without results
        $this->info("\n=== Step 3: Creating missing Results ===");

        $sessionsWithoutResults = QuizSession::whereNotNull('completed_at')
            ->whereDoesntHave('result')
            ->with(['quiz.questions', 'answers.option', 'user'])
            ->get();

        foreach ($sessionsWithoutResults as $session) {
            $quiz = $session->quiz;
            $answers = $session->answers;

            $totalQuestions = $quiz->questions->count();
            $scorePerQuestion = $quiz->questions->first()?->score ?? 5;
            $maxScore = $totalQuestions * $scorePerQuestion;

            $correctAnswers = 0;
            $wrongAnswers = 0;
            $totalScore = 0;

            foreach ($answers as $answer) {
                $isCorrect = $answer->option && $answer->option->is_correct;
                if ($isCorrect) {
                    $correctAnswers++;
                    $totalScore += $scorePerQuestion;
                } else {
                    $wrongAnswers++;
                }
            }

            $unanswered = $totalQuestions - $correctAnswers - $wrongAnswers;
            $percentage = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;
            $isPassed = $percentage >= ($quiz->passing_score ?? 70);

            $completionTime = $session->started_at->diffInSeconds($session->completed_at);

            $result = Result::create([
                'session_id' => $session->id,
                'user_id' => $session->user_id,
                'quiz_id' => $quiz->id,
                'total_score' => $totalScore,
                'max_score' => $maxScore,
                'percentage' => round($percentage, 2),
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'unanswered' => max(0, $unanswered),
                'total_questions' => $totalQuestions,
                'completion_time' => $completionTime,
                'started_at' => $session->started_at,
                'completed_at' => $session->completed_at,
                'is_passed' => $isPassed,
            ]);

            $userName = $session->user ? $session->user->name : 'Unknown';
            $this->info("Created Result #{$result->id} for Session #{$session->id} ({$userName}): {$percentage}%, Correct: {$correctAnswers}/{$totalQuestions}");
        }

        $this->info("\n=== All Done! ===");

        return Command::SUCCESS;
    }
}
