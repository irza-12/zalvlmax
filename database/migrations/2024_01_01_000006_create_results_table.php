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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->nullable()->constrained('quiz_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->decimal('total_score', 8, 2)->default(0);
            $table->decimal('max_score', 8, 2)->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->integer('correct_answers')->default(0);
            $table->integer('wrong_answers')->default(0);
            $table->integer('unanswered')->default(0);
            $table->integer('total_questions')->default(0);
            $table->integer('completion_time')->nullable()->comment('Waktu pengerjaan dalam detik');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->boolean('is_passed')->default(false);
            $table->integer('rank')->nullable()->comment('Peringkat otomatis');
            $table->decimal('percentile', 5, 2)->nullable()->comment('Persentil dalam populasi');
            $table->string('certificate_id', 50)->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('notes')->nullable()->comment('Catatan dari reviewer');
            $table->timestamps();

            $table->index(['user_id', 'quiz_id']);
            $table->index('total_score');
            $table->index('percentage');
            $table->index('completion_time');
            $table->index('rank');
            $table->index('is_passed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};

