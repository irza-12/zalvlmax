<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ReportExport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'report_type',
        'filename',
        'file_path',
        'file_size',
        'filters',
        'status',
        'error_message',
        'downloaded_at',
        'expires_at',
    ];

    protected $casts = [
        'filters' => 'array',
        'downloaded_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Type constants.
     */
    const TYPE_EXCEL = 'excel';
    const TYPE_PDF = 'pdf';
    const TYPE_CSV = 'csv';

    /**
     * Status constants.
     */
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    /**
     * Report type constants.
     */
    const REPORT_QUIZ_RESULTS = 'quiz_results';
    const REPORT_USER_ACTIVITY = 'user_activity';
    const REPORT_STATISTICS = 'statistics';
    const REPORT_LEADERBOARD = 'leaderboard';

    /**
     * Get the user who requested the export.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for completed exports.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope for not expired exports.
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Check if export is ready for download.
     */
    public function isReady(): bool
    {
        return $this->status === self::STATUS_COMPLETED && !$this->isExpired();
    }

    /**
     * Check if export is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Mark as processing.
     */
    public function markAsProcessing(): void
    {
        $this->update(['status' => self::STATUS_PROCESSING]);
    }

    /**
     * Mark as completed.
     */
    public function markAsCompleted(string $filePath, int $fileSize): void
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'expires_at' => now()->addDays(7), // Expire after 7 days
        ]);
    }

    /**
     * Mark as failed.
     */
    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'error_message' => $errorMessage,
        ]);
    }

    /**
     * Mark as downloaded.
     */
    public function markAsDownloaded(): void
    {
        $this->update(['downloaded_at' => now()]);
    }

    /**
     * Get download URL.
     */
    public function getDownloadUrlAttribute(): ?string
    {
        if (!$this->isReady()) {
            return null;
        }

        return route('reports.download', $this);
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size ?? 0;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' bytes';
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu',
            self::STATUS_PROCESSING => 'Diproses',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_FAILED => 'Gagal',
            default => 'Unknown',
        };
    }

    /**
     * Get status color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'gray',
            self::STATUS_PROCESSING => 'blue',
            self::STATUS_COMPLETED => 'green',
            self::STATUS_FAILED => 'red',
            default => 'gray',
        };
    }

    /**
     * Delete the file when model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($export) {
            if ($export->file_path && Storage::exists($export->file_path)) {
                Storage::delete($export->file_path);
            }
        });
    }
}
