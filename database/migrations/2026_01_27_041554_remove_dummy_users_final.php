<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Delete specific dummy users by email
        $dummyEmails = [
            'johndoe@example.com',
            'jane@example.com',
            'bob@example.com',
        ];

        // First delete related data
        $userIds = DB::table('users')
            ->whereIn('email', $dummyEmails)
            ->pluck('id')
            ->toArray();

        if (empty($userIds)) {
            return;
        }

        // Delete quiz_progress for these users' sessions
        DB::table('quiz_progress')
            ->whereIn('session_id', function ($query) use ($userIds) {
                $query->select('id')
                    ->from('quiz_sessions')
                    ->whereIn('user_id', $userIds);
            })
            ->delete();

        // Delete answers
        DB::table('answers')
            ->whereIn('user_id', $userIds)
            ->delete();

        // Delete quiz_leaderboards
        DB::table('quiz_leaderboards')
            ->whereIn('user_id', $userIds)
            ->delete();

        // Delete results
        DB::table('results')
            ->whereIn('user_id', $userIds)
            ->delete();

        // Delete quiz_sessions
        DB::table('quiz_sessions')
            ->whereIn('user_id', $userIds)
            ->delete();

        // Delete activity_logs
        if (DB::getSchemaBuilder()->hasTable('activity_logs')) {
            DB::table('activity_logs')
                ->whereIn('user_id', $userIds)
                ->delete();
        }

        // Finally delete the dummy users
        DB::table('users')
            ->whereIn('email', $dummyEmails)
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot be reversed
    }
};
