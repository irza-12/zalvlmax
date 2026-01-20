<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property string|null $description
 * @property int|null $category_id
 * @property int $duration
 * @property float $passing_score
 * @property int $max_attempts
 * @property bool $shuffle_questions
 * @property bool $shuffle_options
 * @property string $show_result
 * @property bool $show_correct_answer
 * @property \Illuminate\Support\Carbon|null $start_time
 * @property \Illuminate\Support\Carbon|null $end_time
 * @property int|null $created_by
 * @property string $status
 * @property string|null $featured_image
 * @property string $access_type
 * @property string|null $access_password
 * @property array|null $meta
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 */
class Quiz extends Model
{
    use HasFactory;

    /**
     * Status constants.
     */
    const STATUS_DRAFT = 'draft';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_ARCHIVED = 'archived';

    /**
     * Access type constants.
     */
    const ACCESS_PUBLIC = 'public';
    const ACCESS_PRIVATE = 'private';
    const ACCESS_PASSWORD = 'password';

    /**
     * Show result constants.
     */
    const SHOW_IMMEDIATELY = 'immediately';
    const SHOW_AFTER_END = 'after_end';
    const SHOW_NEVER = 'never';

    protected $fillable = [
        'uuid',
        'title',
        'description',
        'category_id',
        'duration',
        'passing_score',
        'max_attempts',
        'shuffle_questions',
        'shuffle_options',
        'show_result',
        'show_correct_answer',
        'start_time',
        'end_time',
        'created_by',
        'status',
        'featured_image',
        'access_type',
        'access_password',
        'meta',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'passing_score' => 'decimal:2',
        'shuffle_questions' => 'boolean',
        'shuffle_options' => 'boolean',
        'show_correct_answer' => 'boolean',
        'meta' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quiz) {
            if (empty($quiz->uuid)) {
                $quiz->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the category for this quiz.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the creator of this quiz.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all questions for this quiz
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    /**
     * Get all results for this quiz
     */
    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Get all sessions for this quiz
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(QuizSession::class);
    }

    /**
     * Get leaderboard entries for this quiz
     */
    public function leaderboard(): HasMany
    {
        return $this->hasMany(QuizLeaderboard::class)->orderBy('rank');
    }

    /**
     * Scope for active quizzes.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope for available quizzes (active and in time range).
     */
    public function scopeAvailable($query)
    {
        $now = now();
        return $query->where('status', self::STATUS_ACTIVE)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_time')
                    ->orWhere('start_time', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_time')
                    ->orWhere('end_time', '>=', $now);
            });
    }

    /**
     * Check if quiz is active
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if quiz is draft
     */
    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * Check if quiz is currently available
     */
    public function isAvailable(): bool
    {
        $now = now();
        $startOk = !$this->start_time || $this->start_time <= $now;
        $endOk = !$this->end_time || $this->end_time >= $now;

        return $this->isActive() && $startOk && $endOk;
    }

    /**
     * Check if quiz has started
     */
    public function hasStarted(): bool
    {
        return !$this->start_time || $this->start_time <= now();
    }

    /**
     * Check if quiz has ended
     */
    public function hasEnded(): bool
    {
        return $this->end_time && $this->end_time < now();
    }

    /**
     * Check if quiz requires password
     */
    public function requiresPassword(): bool
    {
        return $this->access_type === self::ACCESS_PASSWORD && !empty($this->access_password);
    }

    /**
     * Verify access password
     */
    public function verifyPassword(string $password): bool
    {
        return $this->access_password === $password;
    }

    /**
     * Check if user can attempt this quiz
     */
    public function canAttempt(User $user): bool
    {
        // Check if quiz is available
        if (!$this->isAvailable()) {
            return false;
        }

        // Check max attempts
        $attemptCount = $this->sessions()
            ->where('user_id', $user->id)
            ->whereIn('status', ['completed', 'expired'])
            ->count();

        return $attemptCount < $this->max_attempts;
    }

    /**
     * Get remaining attempts for user
     */
    public function getRemainingAttempts(User $user): int
    {
        $attemptCount = $this->sessions()
            ->where('user_id', $user->id)
            ->whereIn('status', ['completed', 'expired'])
            ->count();

        return max(0, $this->max_attempts - $attemptCount);
    }

    /**
     * Get current active session for user
     */
    public function getActiveSession(User $user): ?QuizSession
    {
        return $this->sessions()
            ->where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->first();
    }

    /**
     * Get total questions count
     */
    public function getTotalQuestionsAttribute(): int
    {
        return $this->questions()->count();
    }

    /**
     * Get total score possible
     */
    public function getTotalScoreAttribute(): int
    {
        return $this->questions()->sum('score');
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_INACTIVE => 'Tidak Aktif',
            self::STATUS_ARCHIVED => 'Diarsipkan',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'gray',
            self::STATUS_ACTIVE => 'green',
            self::STATUS_INACTIVE => 'yellow',
            self::STATUS_ARCHIVED => 'red',
            default => 'gray',
        };
    }

    /**
     * Get featured image URL
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }

        return null;
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute(): string
    {
        if ($this->duration >= 60) {
            $hours = floor($this->duration / 60);
            $minutes = $this->duration % 60;
            return $minutes > 0 ? "{$hours} jam {$minutes} menit" : "{$hours} jam";
        }

        return "{$this->duration} menit";
    }

    /**
     * Get stats for this quiz
     */
    public function getStatsAttribute(): array
    {
        $results = $this->results()->whereNotNull('completed_at');

        return [
            'total_attempts' => $results->count(),
            'total_passed' => $results->where('is_passed', true)->count(),
            'avg_score' => $results->avg('percentage') ?? 0,
            'highest_score' => $results->max('percentage') ?? 0,
            'lowest_score' => $results->min('percentage') ?? 0,
            'avg_completion_time' => $results->avg('completion_time') ?? 0,
        ];
    }
}

