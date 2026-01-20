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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->integer('duration'); // in minutes
            $table->decimal('passing_score', 5, 2)->default(60.00);
            $table->integer('max_attempts')->default(1);
            $table->boolean('shuffle_questions')->default(false);
            $table->boolean('shuffle_options')->default(false);
            $table->enum('show_result', ['immediately', 'after_end', 'never'])->default('immediately');
            $table->boolean('show_correct_answer')->default(false);
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['draft', 'active', 'inactive', 'archived'])->default('draft');
            $table->string('featured_image')->nullable();
            $table->enum('access_type', ['public', 'private', 'password'])->default('public');
            $table->string('access_password')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['start_time', 'end_time'], 'idx_start_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};

