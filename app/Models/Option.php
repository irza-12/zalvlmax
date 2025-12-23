<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Get the question that owns this option
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get all answers that selected this option
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
