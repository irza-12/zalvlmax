<?php

namespace App\Console\Commands;

use App\Models\Result;
use App\Models\QuizSession;
use App\Models\QuizLeaderboard;
use Illuminate\Console\Command;

class FixResultSessionLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:result-sessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix missing session_id links in results table and recalculate leaderboards';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Recalculating all leaderboards...');

        try {
            QuizLeaderboard::recalculateAll();
            $this->info('All leaderboards have been recalculated successfully!');
        } catch (\Exception $e) {
            $this->error('Error recalculating leaderboards: ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
