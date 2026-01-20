<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class QuizLeaderboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'result_id',
        'rank',
        'total_score',
        'completion_time',
        'calculated_at',
    ];

    protected $casts = [
        'total_score' => 'decimal:2',
        'calculated_at' => 'datetime',
    ];

    /**
     * Get the quiz.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the result.
     */
    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class);
    }

    /**
     * Get top N entries for a quiz.
     */
    public static function getTopN(int $quizId, int $limit = 10)
    {
        return self::where('quiz_id', $quizId)
            ->orderBy('rank')
            ->limit($limit)
            ->with(['user:id,name,avatar', 'result:id,session_id'])
            ->get();
    }

    /**
     * Get user rank in a quiz.
     */
    public static function getUserRank(int $quizId, int $userId): ?int
    {
        $entry = self::where('quiz_id', $quizId)
            ->where('user_id', $userId)
            ->first();

        return $entry?->rank;
    }

    /**
     * Recalculate leaderboard for a quiz.
     */
    public static function recalculate(int $quizId): void
    {
        // Get all completed results for this quiz, ordered by score (desc) and time (asc)
        // Only take the best result per user (highest score, fastest time)
        $results = Result::where('quiz_id', $quizId)
            ->whereNotNull('completed_at')
            ->orderByDesc('total_score')
            ->orderBy('completion_time')
            ->with('user:id')
            ->get()
            ->unique('user_id') // Only keep the best result per user
            ->values();

        // Clear existing leaderboard entries for this quiz
        self::where('quiz_id', $quizId)->delete();

        // Insert new entries
        $rank = 1;
        $previousScore = null;
        $previousTime = null;
        $actualRank = 1;
        $processedUsers = [];

        foreach ($results as $result) {
            // Skip if we've already processed this user (extra safety)
            if (in_array($result->user_id, $processedUsers)) {
                continue;
            }
            $processedUsers[] = $result->user_id;

            // Handle ties: same score and time = same rank
            if (
                $previousScore !== null &&
                $result->total_score == $previousScore &&
                $result->completion_time == $previousTime
            ) {
                // Same rank as previous
            } else {
                $actualRank = $rank;
            }

            try {
                self::create([
                    'quiz_id' => $quizId,
                    'user_id' => $result->user_id,
                    'result_id' => $result->id,
                    'rank' => $actualRank,
                    'total_score' => $result->total_score,
                    'completion_time' => $result->completion_time ?? 0,
                    'calculated_at' => now(),
                ]);
            } catch (\Exception $e) {
                // Skip if duplicate entry error
                continue;
            }

            $previousScore = $result->total_score;
            $previousTime = $result->completion_time;
            $rank++;
        }
    }

    /**
     * Recalculate all leaderboards.
     */
    public static function recalculateAll(): void
    {
        $quizIds = Quiz::where('status', 'active')->pluck('id');

        foreach ($quizIds as $quizId) {
            self::recalculate($quizId);
        }
    }

    /**
     * Get formatted completion time.
     */
    public function getFormattedTimeAttribute(): string
    {
        $seconds = $this->completion_time;
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        if ($minutes > 0) {
            return sprintf('%d:%02d', $minutes, $remainingSeconds);
        }

        return sprintf('%d detik', $remainingSeconds);
    }

    /**
     * Get rank suffix.
     */
    public function getRankSuffixAttribute(): string
    {
        if ($this->rank === 1)
            return 'st';
        if ($this->rank === 2)
            return 'nd';
        if ($this->rank === 3)
            return 'rd';
        return 'th';
    }

    /**
     * Get rank display.
     */
    public function getRankDisplayAttribute(): string
    {
        return $this->rank . $this->rank_suffix;
    }
}
