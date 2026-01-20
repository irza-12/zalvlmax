<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Answer;
use App\Models\QuizSession;
use Illuminate\Support\Facades\DB;

class FixAnswerSessions extends Command
{
    protected $signature = 'answers:fix-sessions';
    protected $description = 'Link answers to their corresponding sessions';

    public function handle()
    {
        $this->info('Starting to link answers to sessions...');

        $answers = Answer::whereNull('session_id')->with(['question', 'user'])->get();
        $count = 0;
        $skipped = 0;

        $bar = $this->output->createProgressBar($answers->count());

        foreach ($answers as $answer) {
            if (!$answer->question) {
                $skipped++;
                $bar->advance();
                continue;
            }

            $quizId = $answer->question->quiz_id;
            $userId = $answer->user_id;

            // Find matching session
            // We verify by user_id and quiz_id
            // Ideally we should also check timestamps if there are multiple attempts, 
            // but for recovery let's take the latest completed session or the latest session.
            $session = QuizSession::where('user_id', $userId)
                ->where('quiz_id', $quizId)
                ->latest()
                ->first();

            if ($session) {
                $answer->update(['session_id' => $session->id]);
                $count++;
            } else {
                // If no session exists, we might need to create one logically, 
                // but for now let's just count it as skipped/failed to link.
                // In a perfect world we would create a session back for them.
                $skipped++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nLinked {$count} answers to sessions.");
        $this->info("Skipped {$skipped} answers (no matching session found).");

        return Command::SUCCESS;
    }
}
