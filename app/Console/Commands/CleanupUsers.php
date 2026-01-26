<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Result;
use App\Models\Answer;
use App\Models\QuizSession;
use App\Models\QuizProgress;
use App\Models\QuizLeaderboard;
use Illuminate\Console\Command;

class CleanupUsers extends Command
{
    protected $signature = 'users:cleanup';
    protected $description = 'Delete all users except superadmin and admin';

    public function handle()
    {
        // Get users to keep (superadmin and admin roles)
        $usersToKeep = User::whereIn('role', ['superadmin', 'super_admin', 'admin'])->pluck('id')->toArray();

        $this->info('Users to keep: ' . count($usersToKeep));
        User::whereIn('id', $usersToKeep)->each(function ($user) {
            $this->line(" - {$user->name} ({$user->role})");
        });

        // Get users to delete
        $usersToDelete = User::whereNotIn('id', $usersToKeep)->get();
        $this->info("\nUsers to delete: " . $usersToDelete->count());

        if ($usersToDelete->isEmpty()) {
            $this->info('No users to delete.');
            return 0;
        }

        $usersToDelete->each(function ($user) {
            $this->line(" - {$user->name} ({$user->role})");
        });

        if (!$this->confirm('Do you want to delete these users and their related data?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        $userIdsToDelete = $usersToDelete->pluck('id')->toArray();

        // Delete related data
        $this->info("\nDeleting related data...");

        // Delete quiz progress
        $progressDeleted = QuizProgress::whereHas('session', function ($query) use ($userIdsToDelete) {
            $query->whereIn('user_id', $userIdsToDelete);
        })->delete();
        $this->line(" - Quiz Progress deleted: {$progressDeleted}");

        // Delete answers
        $answersDeleted = Answer::whereIn('user_id', $userIdsToDelete)->delete();
        $this->line(" - Answers deleted: {$answersDeleted}");

        // Delete leaderboard entries
        $leaderboardDeleted = QuizLeaderboard::whereIn('user_id', $userIdsToDelete)->delete();
        $this->line(" - Leaderboard entries deleted: {$leaderboardDeleted}");

        // Delete results
        $resultsDeleted = Result::whereIn('user_id', $userIdsToDelete)->delete();
        $this->line(" - Results deleted: {$resultsDeleted}");

        // Delete quiz sessions
        $sessionsDeleted = QuizSession::whereIn('user_id', $userIdsToDelete)->delete();
        $this->line(" - Quiz Sessions deleted: {$sessionsDeleted}");

        // Delete users
        $usersDeleted = User::whereIn('id', $userIdsToDelete)->delete();
        $this->line(" - Users deleted: {$usersDeleted}");

        // Recalculate all leaderboards
        $this->info("\nRecalculating leaderboards...");
        QuizLeaderboard::recalculateAll();
        $this->info('All leaderboards have been recalculated.');

        $this->info("\n✓ Cleanup completed successfully!");

        return 0;
    }
}
