<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\QuizSession;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LinkAnswersToSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:link-answers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Link existing answers to their corresponding quiz sessions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to link answers to sessions...');

        $sessions = QuizSession::all();
        $this->info("Found {$sessions->count()} sessions to process.");

        $linkedCount = 0;

        foreach ($sessions as $session) {
            // Find answers belonging to this user and the quiz of this session
            // that don't have a session_id yet.

            // We use a subquery/join to filter answers by quiz_id via questions table
            $affected = DB::table('answers')
                ->join('questions', 'answers.question_id', '=', 'questions.id')
                ->where('answers.user_id', $session->user_id)
                ->where('questions.quiz_id', $session->quiz_id)
                ->whereNull('answers.session_id')
                ->update(['answers.session_id' => $session->id]);

            if ($affected > 0) {
                $linkedCount += $affected;
                $this->line("Session #{$session->id}: Linked {$affected} answers.");
            }
        }

        $this->info("Done! Linked total of {$linkedCount} answers.");

        return Command::SUCCESS;
    }
}
