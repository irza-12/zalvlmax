<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class QuizSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'quiz_id',
        'attempt_number',
        'started_at',
        'completed_at',
        'expires_at',
        'status',
        'current_question_index',
        'ip_address',
        'user_agent',
        'browser_info',
        'tab_switches',
        'last_this_activity_at',
        'kick_reason',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'expires_at' => 'datetime',
        'browser_info' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($session) {
            if (empty($session->uuid)) {
                $session->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the user who owns this session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quiz for this session.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get progress records for this session.
     */
    public function progress(): HasMany
    {
        return $this->hasMany(QuizProgress::class, 'session_id');
    }

    /**
     * Get answers for this session.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'session_id');
    }

    /**
     * Get the result for this session.
     */
    public function result(): HasOne
    {
        return $this->hasOne(Result::class, 'session_id');
    }

    /**
     * Scope for in-progress sessions.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope for completed sessions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Check if session is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if session is in progress.
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if session is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Get remaining time in seconds.
     */
    public function getRemainingTimeAttribute(): int
    {
        if (!$this->expires_at) {
            return 0;
        }

        $remaining = $this->expires_at->diffInSeconds(now(), false);
        return max(0, -$remaining);
    }

    /**
     * Get elapsed time in seconds.
     */
    public function getElapsedTimeAttribute(): int
    {
        if (!$this->started_at) {
            return 0;
        }

        $endTime = $this->completed_at ?? now();
        return $this->started_at->diffInSeconds($endTime);
    }

    /**
     * Get answered questions count.
     */
    public function getAnsweredCountAttribute(): int
    {
        return $this->progress()->where('status', 'answered')->count();
    }

    /**
     * Get progress percentage.
     */
    public function getProgressPercentageAttribute(): float
    {
        $totalQuestions = $this->quiz->questions()->count();
        if ($totalQuestions === 0) {
            return 0;
        }

        return round(($this->answered_count / $totalQuestions) * 100, 1);
    }

    /**
     * Mark session as completed.
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Mark session as expired.
     */
    public function markAsExpired(): void
    {
        $this->update([
            'status' => 'expired',
            'completed_at' => now(),
        ]);
    }
}
