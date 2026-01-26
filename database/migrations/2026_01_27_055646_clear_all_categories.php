<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, remove category_id from quizzes to avoid foreign key issues
        DB::table('quizzes')->update(['category_id' => null]);

        // Delete all categories
        DB::table('categories')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot be reversed - categories are permanently deleted
    }
};
