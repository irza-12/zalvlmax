<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'question_id',
        'option_id',
        'selected_options',
        'essay_answer',
        'is_correct',
        'score_obtained',
        'answered_at',
        'time_spent',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'score_obtained' => 'decimal:2',
        'selected_options' => 'array',
        'answered_at' => 'datetime',
    ];

    /**
     * Get the session this answer belongs to
     */
    public function session()
    {
        return $this->belongsTo(QuizSession::class, 'session_id');
    }

    /**
     * Get the user that owns this answer
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the question that this answer belongs to
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the option that was selected
     */
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    /**
     * Check if this answer is correct
     */
    public function isCorrect(): bool
    {
        // First check if is_correct is already set
        if ($this->is_correct !== null) {
            return (bool) $this->is_correct;
        }

        // Otherwise calculate from option
        return $this->option && $this->option->is_correct;
    }
}
