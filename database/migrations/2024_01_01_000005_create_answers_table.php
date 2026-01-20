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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->nullable()->constrained('quiz_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->foreignId('option_id')->nullable()->constrained()->onDelete('set null');
            $table->json('selected_options')->nullable()->comment('Untuk multiple_correct');
            $table->text('essay_answer')->nullable()->comment('Untuk essay/fill_blank');
            $table->boolean('is_correct')->nullable();
            $table->decimal('score_obtained', 8, 2)->default(0);
            $table->timestamp('answered_at')->nullable();
            $table->integer('time_spent')->default(0)->comment('Waktu dalam detik');
            $table->timestamps();

            $table->index(['user_id', 'question_id']);
            $table->index('is_correct');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};

