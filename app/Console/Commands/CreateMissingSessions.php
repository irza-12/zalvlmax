<?php

namespace App\Console\Commands;

use App\Models\Result;
use App\Models\QuizSession;
use App\Models\QuizLeaderboard;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateMissingSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:create-sessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create missing quiz sessions for results that dont have any and recalculate leaderboards';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Finding results without sessions...');

        // Get all results without session_id
        $results = Result::whereNull('session_id')->get();

        $this->info("Found {$results->count()} results without session_id");

        $created = 0;
        $skipped = 0;

        foreach ($results as $result) {
            // Check if a session already exists for this user/quiz
            $existingSession = QuizSession::where('user_id', $result->user_id)
                ->where('quiz_id', $result->quiz_id)
                ->first();

            if ($existingSession) {
                // Check if this session is already linked to another result
                $linkedResult = Result::where('session_id', $existingSession->id)
                    ->where('id', '!=', $result->id)
                    ->first();

                if ($linkedResult) {
                    $this->warn("Result #{$result->id}: Session #{$existingSession->id} already linked to result #{$linkedResult->id}, creating new session");
                } else {
                    // Link to existing session
                    try {
                        $result->session_id = $existingSession->id;
                        $result->started_at = $existingSession->started_at;
                        $result->save();
                        $this->line("Result #{$result->id}: Linked to existing session #{$existingSession->id}");
                        $created++;
                        continue;
                    } catch (\Exception $e) {
                        $this->warn("Could not link result #{$result->id} to session #{$existingSession->id}: " . $e->getMessage());
                    }
                }
            }

            // Create new session for this result
            try {
                $startedAt = $result->started_at ?? $result->created_at ?? now()->subMinutes(30);
                $completedAt = $result->completed_at ?? $result->created_at ?? now();

                $session = QuizSession::create([
                    'uuid' => Str::uuid(),
                    'user_id' => $result->user_id,
                    'quiz_id' => $result->quiz_id,
                    'attempt_number' => 1,
                    'started_at' => $startedAt,
                    'completed_at' => $completedAt,
                    'status' => 'completed',
                    'current_question_index' => $result->total_questions ?? 0,
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Migrated Session',
                ]);

                // Link result to new session
                $result->session_id = $session->id;
                $result->started_at = $startedAt;
                $result->save();

                $this->line("Result #{$result->id}: Created new session #{$session->id}");
                $created++;
            } catch (\Exception $e) {
                $this->error("Error creating session for result #{$result->id}: " . $e->getMessage());
                $skipped++;
            }
        }

        $this->info("\nCreated/Linked: {$created} sessions");
        $this->info("Skipped: {$skipped}");

        // Recalculate leaderboards
        $this->info("\nRecalculating all leaderboards...");
        try {
            QuizLeaderboard::recalculateAll();
            $this->info('All leaderboards have been recalculated successfully!');
        } catch (\Exception $e) {
            $this->error('Error recalculating leaderboards: ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
