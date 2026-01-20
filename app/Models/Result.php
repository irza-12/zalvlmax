<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'quiz_id',
        'total_score',
        'max_score',
        'percentage',
        'correct_answers',
        'wrong_answers',
        'unanswered',
        'total_questions',
        'completion_time',
        'started_at',
        'completed_at',
        'is_passed',
        'rank',
        'percentile',
        'certificate_id',
        'reviewed_by',
        'reviewed_at',
        'notes',
    ];

    protected $casts = [
        'total_score' => 'decimal:2',
        'max_score' => 'decimal:2',
        'percentage' => 'decimal:2',
        'percentile' => 'decimal:2',
        'is_passed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the session that this result belongs to
     */
    public function session()
    {
        return $this->belongsTo(QuizSession::class, 'session_id');
    }

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
     * Get the reviewer
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get formatted completion time
     */
    public function getFormattedCompletionTimeAttribute(): string
    {
        if (!$this->completion_time) {
            return '-';
        }

        $totalSeconds = abs($this->completion_time);
        $minutes = floor($totalSeconds / 60);
        $seconds = $totalSeconds % 60;

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
        return $this->completed_at ? 'Selesai' : 'Sedang Mengerjakan';
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return $this->completed_at ? 'emerald' : 'amber';
    }

    /**
     * Get pass status label
     */
    public function getPassStatusLabelAttribute(): string
    {
        return $this->is_passed ? 'LULUS' : 'TIDAK LULUS';
    }

    /**
     * Get pass status color
     */
    public function getPassStatusColorAttribute(): string
    {
        return $this->is_passed ? 'success' : 'danger';
    }

    /**
     * Check if result is passed (use database value for consistency)
     */
    public function isPassed(): bool
    {
        return (bool) $this->is_passed;
    }
}
