<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $quiz_id
 * @property string $question_text
 * @property string $type
 * @property int $score
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Quiz $quiz
 */
class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'type',
        'score',
    ];

    /**
     * Get the quiz that owns this question
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get all options for this question
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Get all answers for this question
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get correct options
     */
    public function correctOptions()
    {
        return $this->options()->where('is_correct', true);
    }

    /**
     * Check if answer is correct
     */
    public function isCorrectAnswer($optionId): bool
    {
        if ($this->type === 'multiple_correct') {
            // For multiple correct, need to check all selected options
            return $this->options()->where('id', $optionId)->where('is_correct', true)->exists();
        }

        return $this->options()->where('id', $optionId)->where('is_correct', true)->exists();
    }
}
