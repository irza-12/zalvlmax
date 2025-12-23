<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'total_score',
        'correct_answers',
        'wrong_answers',
        'completion_time',
    ];

    protected $casts = [
        'total_score' => 'decimal:2',
    ];

    /**
     * Get the user that owns this result
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quiz that this result belongs to
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get formatted completion time
     */
    public function getFormattedCompletionTimeAttribute(): string
    {
        if (!$this->completion_time) {
            return '-';
        }

        $minutes = floor($this->completion_time / 60);
        $seconds = $this->completion_time % 60;

        if ($minutes > 0) {
            return sprintf('%d Menit %d Detik', $minutes, $seconds);
        }

        return sprintf('%d Detik', $seconds);
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->completion_time ? 'Selesai' : 'Sedang Mengerjakan';
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return $this->completion_time ? 'success' : 'warning';
    }

    /**
     * Get percentage score
     */
    public function getPercentageAttribute(): float
    {
        $totalQuestions = $this->correct_answers + $this->wrong_answers;
        if ($totalQuestions === 0) {
            return 0;
        }

        return round(($this->correct_answers / $totalQuestions) * 100, 2);
    }
}
