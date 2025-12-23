<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $duration
 * @property \Illuminate\Support\Carbon $start_time
 * @property \Illuminate\Support\Carbon $end_time
 * @property string $status
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 */
class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get all questions for this quiz
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get all results for this quiz
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Check if quiz is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if quiz is currently available
     */
    public function isAvailable(): bool
    {
        $now = now();
        return $this->isActive()
            && $this->start_time <= $now
            && $this->end_time >= $now;
    }

    /**
     * Check if quiz has started
     */
    public function hasStarted(): bool
    {
        return $this->start_time <= now();
    }

    /**
     * Check if quiz has ended
     */
    public function hasEnded(): bool
    {
        return $this->end_time < now();
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
}
