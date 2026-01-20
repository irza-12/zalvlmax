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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->enum('type', ['multiple_choice', 'true_false', 'multiple_correct', 'essay', 'fill_blank'])->default('multiple_choice');
            $table->integer('score')->default(10);
            $table->integer('negative_score')->default(0)->comment('Pengurangan nilai jika salah');
            $table->integer('time_limit')->nullable()->comment('Waktu per soal dalam detik');
            $table->integer('order')->default(0);
            $table->text('explanation')->nullable()->comment('Penjelasan jawaban benar');
            $table->string('image')->nullable();
            $table->boolean('is_required')->default(true);
            $table->timestamps();

            $table->index('quiz_id');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};

