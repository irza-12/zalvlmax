<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get IDs of admin users to keep
        $adminUserIds = DB::table('users')
            ->whereIn('role', ['super_admin', 'admin', 'superadmin'])
            ->pluck('id')
            ->toArray();

        if (empty($adminUserIds)) {
            return; // No admins found, skip cleanup
        }

        // Delete related data for non-admin users
        // 1. Delete quiz_progress for non-admin sessions
        DB::table('quiz_progress')
            ->whereIn('session_id', function ($query) use ($adminUserIds) {
                $query->select('id')
                    ->from('quiz_sessions')
                    ->whereNotIn('user_id', $adminUserIds);
            })
            ->delete();

        // 2. Delete answers for non-admin users
        DB::table('answers')
            ->whereNotIn('user_id', $adminUserIds)
            ->delete();

        // 3. Delete quiz_leaderboards for non-admin users
        DB::table('quiz_leaderboards')
            ->whereNotIn('user_id', $adminUserIds)
            ->delete();

        // 4. Delete results for non-admin users
        DB::table('results')
            ->whereNotIn('user_id', $adminUserIds)
            ->delete();

        // 5. Delete quiz_sessions for non-admin users
        DB::table('quiz_sessions')
            ->whereNotIn('user_id', $adminUserIds)
            ->delete();

        // 6. Delete activity_logs for non-admin users (optional)
        if (DB::getSchemaBuilder()->hasTable('activity_logs')) {
            DB::table('activity_logs')
                ->whereNotIn('user_id', $adminUserIds)
                ->delete();
        }

        // 7. Finally, delete non-admin users
        DB::table('users')
            ->whereNotIn('id', $adminUserIds)
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be reversed - data is permanently deleted
    }
};
