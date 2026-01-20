<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizProgress extends Model
{
    use HasFactory;

    protected $table = 'quiz_progress';

    protected $fillable = [
        'session_id',
        'question_id',
        'status',
        'time_spent',
        'visited_at',
        'answered_at',
        'last_activity_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'answered_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Status constants.
     */
    const STATUS_NOT_VISITED = 'not_visited';
    const STATUS_VISITED = 'visited';
    const STATUS_ANSWERED = 'answered';
    const STATUS_MARKED_REVIEW = 'marked_review';
    const STATUS_SKIPPED = 'skipped';

    /**
     * Get the session this progress belongs to.
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(QuizSession::class, 'session_id');
    }

    /**
     * Get the question for this progress.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Scope for answered questions.
     */
    public function scopeAnswered($query)
    {
        return $query->where('status', self::STATUS_ANSWERED);
    }

    /**
     * Scope for not visited questions.
     */
    public function scopeNotVisited($query)
    {
        return $query->where('status', self::STATUS_NOT_VISITED);
    }

    /**
     * Scope for skipped questions.
     */
    public function scopeSkipped($query)
    {
        return $query->where('status', self::STATUS_SKIPPED);
    }

    /**
     * Scope for marked for review questions.
     */
    public function scopeMarkedReview($query)
    {
        return $query->where('status', self::STATUS_MARKED_REVIEW);
    }

    /**
     * Mark as visited.
     */
    public function markAsVisited(): void
    {
        if ($this->status === self::STATUS_NOT_VISITED) {
            $this->update([
                'status' => self::STATUS_VISITED,
                'visited_at' => now(),
                'last_activity_at' => now(),
            ]);
        }
    }

    /**
     * Mark as answered.
     */
    public function markAsAnswered(): void
    {
        $this->update([
            'status' => self::STATUS_ANSWERED,
            'answered_at' => now(),
            'last_activity_at' => now(),
        ]);
    }

    /**
     * Mark as skipped.
     */
    public function markAsSkipped(): void
    {
        $this->update([
            'status' => self::STATUS_SKIPPED,
            'last_activity_at' => now(),
        ]);
    }

    /**
     * Mark for review.
     */
    public function markForReview(): void
    {
        $this->update([
            'status' => self::STATUS_MARKED_REVIEW,
            'last_activity_at' => now(),
        ]);
    }

    /**
     * Add time spent.
     */
    public function addTimeSpent(int $seconds): void
    {
        $this->increment('time_spent', $seconds);
        $this->update(['last_activity_at' => now()]);
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_NOT_VISITED => 'Belum Dikunjungi',
            self::STATUS_VISITED => 'Dikunjungi',
            self::STATUS_ANSWERED => 'Dijawab',
            self::STATUS_MARKED_REVIEW => 'Ditandai Review',
            self::STATUS_SKIPPED => 'Dilewati',
            default => 'Unknown',
        };
    }

    /**
     * Get status color for UI.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_NOT_VISITED => 'gray',
            self::STATUS_VISITED => 'blue',
            self::STATUS_ANSWERED => 'green',
            self::STATUS_MARKED_REVIEW => 'yellow',
            self::STATUS_SKIPPED => 'red',
            default => 'gray',
        };
    }
}
