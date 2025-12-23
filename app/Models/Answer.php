<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id',
        'option_id',
    ];

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
        return $this->option && $this->option->is_correct;
    }
}
