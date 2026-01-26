<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\GanisPKBQuizSeeder;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Jalankan seeder Ganis PKB
        Artisan::call('db:seed', [
            '--class' => GanisPKBQuizSeeder::class,
            '--force' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu rollback data seeder
    }
};
