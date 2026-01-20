<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_leaderboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('result_id')->constrained()->onDelete('cascade');
            $table->integer('rank');
            $table->decimal('total_score', 8, 2);
            $table->integer('completion_time')->comment('Waktu dalam detik');
            $table->timestamp('calculated_at');
            $table->timestamps();

            $table->unique(['quiz_id', 'user_id'], 'unique_quiz_user');
            $table->index(['quiz_id', 'rank'], 'idx_quiz_rank');
            $table->index(['total_score', 'completion_time'], 'idx_score_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_leaderboards');
    }
};
