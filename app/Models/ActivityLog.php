<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'loggable_type',
        'loggable_id',
        'action',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Action constants.
     */
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    const ACTION_LOGIN_FAILED = 'login_failed';
    const ACTION_PASSWORD_RESET = 'password_reset';
    const ACTION_QUIZ_STARTED = 'quiz_started';
    const ACTION_QUIZ_COMPLETED = 'quiz_completed';
    const ACTION_QUIZ_EXPIRED = 'quiz_expired';
    const ACTION_EXPORT = 'export';
    const ACTION_VIEW = 'view';

    /**
     * Get the user who performed the action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the loggable model.
     */
    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope for specific action.
     */
    public function scopeAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope for specific user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Log an activity.
     */
    public static function log(
        string $action,
        ?string $description = null,
        ?Model $loggable = null,
        ?array $properties = null
    ): self {
        $user = auth()->user();

        return self::create([
            'user_id' => $user?->id,
            'loggable_type' => $loggable ? get_class($loggable) : null,
            'loggable_id' => $loggable?->id,
            'action' => $action,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get action label.
     */
    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            self::ACTION_CREATE => 'Membuat',
            self::ACTION_UPDATE => 'Mengubah',
            self::ACTION_DELETE => 'Menghapus',
            self::ACTION_LOGIN => 'Login',
            self::ACTION_LOGOUT => 'Logout',
            self::ACTION_LOGIN_FAILED => 'Login Gagal',
            self::ACTION_PASSWORD_RESET => 'Reset Password',
            self::ACTION_QUIZ_STARTED => 'Memulai Kuis',
            self::ACTION_QUIZ_COMPLETED => 'Menyelesaikan Kuis',
            self::ACTION_QUIZ_EXPIRED => 'Kuis Expired',
            self::ACTION_EXPORT => 'Export',
            self::ACTION_VIEW => 'Melihat',
            default => ucfirst($this->action),
        };
    }

    /**
     * Get action color for UI.
     */
    public function getActionColorAttribute(): string
    {
        return match ($this->action) {
            self::ACTION_CREATE => 'green',
            self::ACTION_UPDATE => 'blue',
            self::ACTION_DELETE => 'red',
            self::ACTION_LOGIN => 'green',
            self::ACTION_LOGOUT => 'gray',
            self::ACTION_LOGIN_FAILED => 'red',
            self::ACTION_QUIZ_STARTED => 'purple',
            self::ACTION_QUIZ_COMPLETED => 'green',
            self::ACTION_QUIZ_EXPIRED => 'orange',
            self::ACTION_EXPORT => 'blue',
            default => 'gray',
        };
    }
}
