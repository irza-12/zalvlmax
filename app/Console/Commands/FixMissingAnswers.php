<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Quiz;
use App\Models\Result;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixMissingAnswers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:missing-answers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate missing answers for existing results';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for results with missing answers...');

        $results = Result::with(['quiz.questions.options', 'session'])->get();

        foreach ($results as $result) {
            $this->info("Processing Result ID: {$result->id} (User: {$result->user_id}, Score: {$result->total_score})");

            // Check existing answers count via session
            $answersCount = 0;
            if ($result->session) {
                $answersCount = Answer::where('session_id', $result->session->id)->count();
            } else {
                // Fallback check user answers if session missing (for legacy data)
                // Note: this is risky but we only check.
                // Actually, let's rely on session. If session missing, we create answers with NULL session_id?
                // Or better, create a dummy session if missing.
                $answersCount = Answer::where('user_id', $result->user_id)
                    ->whereIn('question_id', $result->quiz->questions->pluck('id'))
                    ->count();
            }

            if ($answersCount > 0) {
                $this->info("  - OK: Has {$answersCount} answers.");
                continue;
            }

            $this->warn("  - EMPTY: No answers found! Generating dummy answers...");

            if (!$result->quiz) {
                $this->error("  - ERROR: Quiz not found for result.");
                continue;
            }

            DB::beginTransaction();
            try {
                $totalScore = 0;
                $correctCount = 0;
                $wrongCount = 0;

                foreach ($result->quiz->questions as $question) {
                    // Pick a random option
                    $option = $question->options->random();
                    $isCorrect = $option->is_correct;
                    $score = $isCorrect ? $question->score : 0;

                    $totalScore += $score;
                    if ($isCorrect)
                        $correctCount++;
                    else
                        $wrongCount++;

                    Answer::create([
                        'session_id' => $result->session_id, // Could be null
                        'user_id' => $result->user_id,
                        'question_id' => $question->id,
                        'option_id' => $option->id,
                        'is_correct' => $isCorrect,
                        'score_obtained' => $score,
                        'answered_at' => now(),
                    ]);
                }

                // Update result with new score based on generated answers
                $result->update([
                    'total_score' => $totalScore,
                    'correct_answers' => $correctCount,
                    'wrong_answers' => $wrongCount,
                    'percentage' => ($totalScore / max(1, $result->quiz->total_score)) * 100,
                ]);

                DB::commit();
                $this->info("  - SUCCESS: Generated answers. New Score: {$totalScore}");

            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("  - FAILED: " . $e->getMessage());
            }
        }

        $this->info('Done.');
    }
}
