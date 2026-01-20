<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Result;
use App\Models\ReportExport;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ReportService
{
    /**
     * Get quiz results with filters.
     */
    public function getQuizResults(array $filters = []): Collection
    {
        $query = Result::with(['user:id,name,email', 'quiz:id,title,category_id'])
            ->whereNotNull('completed_at');

        // Filter by quiz
        if (!empty($filters['quiz_id'])) {
            $query->where('quiz_id', $filters['quiz_id']);
        }

        // Filter by user
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        // Filter by date range
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('completed_at', [
                Carbon::parse($filters['start_date'])->startOfDay(),
                Carbon::parse($filters['end_date'])->endOfDay(),
            ]);
        }

        // Filter by passed status
        if (isset($filters['is_passed'])) {
            $query->where('is_passed', $filters['is_passed']);
        }

        // Sort
        $sortBy = $filters['sort_by'] ?? 'completed_at';
        $sortDir = $filters['sort_dir'] ?? 'desc';
        $query->orderBy($sortBy, $sortDir);

        return $query->get();
    }

    /**
     * Generate statistics summary.
     */
    public function getStatisticsSummary(array $filters = []): array
    {
        $results = $this->getQuizResults($filters);

        if ($results->isEmpty()) {
            return [
                'total_attempts' => 0,
                'total_passed' => 0,
                'total_failed' => 0,
                'pass_rate' => 0,
                'avg_score' => 0,
                'highest_score' => 0,
                'lowest_score' => 0,
                'avg_completion_time' => 0,
            ];
        }

        $totalAttempts = $results->count();
        $totalPassed = $results->where('is_passed', true)->count();
        $totalFailed = $totalAttempts - $totalPassed;

        return [
            'total_attempts' => $totalAttempts,
            'total_passed' => $totalPassed,
            'total_failed' => $totalFailed,
            'pass_rate' => round(($totalPassed / $totalAttempts) * 100, 1),
            'avg_score' => round($results->avg('percentage'), 1),
            'highest_score' => round($results->max('percentage'), 1),
            'lowest_score' => round($results->min('percentage'), 1),
            'avg_completion_time' => round($results->avg('completion_time')),
        ];
    }

    /**
     * Get data for per-quiz report.
     */
    public function getPerQuizReport(array $filters = []): array
    {
        $query = Quiz::withCount([
            'results as total_attempts' => function ($q) {
                $q->whereNotNull('completed_at');
            }
        ])
            ->withAvg('results as avg_score', 'percentage')
            ->withMax('results as highest_score', 'percentage')
            ->withMin('results as lowest_score', 'percentage')
            ->where('status', '!=', 'draft');

        // Filter by category
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Filter by date range (based on quiz creation or result completion)
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereHas('results', function ($q) use ($filters) {
                $q->whereBetween('completed_at', [
                    Carbon::parse($filters['start_date'])->startOfDay(),
                    Carbon::parse($filters['end_date'])->endOfDay(),
                ]);
            });
        }

        return $query->get()->map(function ($quiz) {
            $passedCount = $quiz->results()->where('is_passed', true)->count();
            $passRate = $quiz->total_attempts > 0 ? ($passedCount / $quiz->total_attempts) * 100 : 0;

            return [
                'quiz_id' => $quiz->id,
                'title' => $quiz->title,
                'category' => $quiz->category?->name ?? '-',
                'total_attempts' => $quiz->total_attempts ?? 0,
                'avg_score' => round($quiz->avg_score ?? 0, 1),
                'highest_score' => round($quiz->highest_score ?? 0, 1),
                'lowest_score' => round($quiz->lowest_score ?? 0, 1),
                'pass_rate' => round($passRate, 1),
                'status' => $quiz->status_label,
            ];
        })->toArray();
    }

    /**
     * Get data for per-user report.
     */
    public function getPerUserReport(array $filters = []): array
    {
        $query = User::role('user')
            ->withCount([
                'results as total_quizzes' => function ($q) {
                    $q->whereNotNull('completed_at');
                }
            ])
            ->withAvg('results as avg_score', 'percentage')
            ->withMax('results as best_score', 'percentage')
            ->active();

        // Filter by date range
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereHas('results', function ($q) use ($filters) {
                $q->whereBetween('completed_at', [
                    Carbon::parse($filters['start_date'])->startOfDay(),
                    Carbon::parse($filters['end_date'])->endOfDay(),
                ]);
            });
        }

        return $query->get()->map(function ($user) {
            $passedCount = $user->results()->where('is_passed', true)->count();

            return [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'total_quizzes' => $user->total_quizzes ?? 0,
                'passed_quizzes' => $passedCount,
                'avg_score' => round($user->avg_score ?? 0, 1),
                'best_score' => round($user->best_score ?? 0, 1),
                'last_activity' => $user->results()->latest('completed_at')->first()?->completed_at?->format('d/m/Y H:i') ?? '-',
            ];
        })->toArray();
    }

    /**
     * Get data for period report.
     */
    public function getPeriodReport(array $filters = []): array
    {
        $startDate = Carbon::parse($filters['start_date'] ?? now()->subMonth());
        $endDate = Carbon::parse($filters['end_date'] ?? now());
        $groupBy = $filters['group_by'] ?? 'day'; // day, week, month

        $results = Result::whereNotNull('completed_at')
            ->whereBetween('completed_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->get();

        // Group by period
        $grouped = $results->groupBy(function ($result) use ($groupBy) {
            return match ($groupBy) {
                'week' => $result->completed_at->startOfWeek()->format('Y-m-d'),
                'month' => $result->completed_at->format('Y-m'),
                default => $result->completed_at->format('Y-m-d'),
            };
        });

        return $grouped->map(function ($periodResults, $period) use ($groupBy) {
            $totalAttempts = $periodResults->count();
            $passedCount = $periodResults->where('is_passed', true)->count();

            return [
                'period' => $period,
                'period_label' => $this->formatPeriodLabel($period, $groupBy),
                'total_attempts' => $totalAttempts,
                'passed' => $passedCount,
                'failed' => $totalAttempts - $passedCount,
                'avg_score' => round($periodResults->avg('percentage'), 1),
                'unique_users' => $periodResults->pluck('user_id')->unique()->count(),
            ];
        })->values()->toArray();
    }

    /**
     * Create a report export record.
     */
    public function createExportRecord(User $user, string $type, string $reportType, array $filters = []): ReportExport
    {
        $extension = match ($type) {
            'excel' => 'xlsx',
            'pdf' => 'pdf',
            'csv' => 'csv',
            default => 'xlsx',
        };

        $filename = sprintf(
            '%s_%s_%s.%s',
            $reportType,
            now()->format('Y-m-d_His'),
            substr(md5(uniqid()), 0, 8),
            $extension
        );

        return ReportExport::create([
            'user_id' => $user->id,
            'type' => $type,
            'report_type' => $reportType,
            'filename' => $filename,
            'file_path' => "exports/{$filename}",
            'filters' => $filters,
            'status' => ReportExport::STATUS_PENDING,
        ]);
    }

    /**
     * Format period label based on group type.
     */
    private function formatPeriodLabel(string $period, string $groupBy): string
    {
        return match ($groupBy) {
            'week' => 'Minggu ' . Carbon::parse($period)->format('d M Y'),
            'month' => Carbon::parse($period . '-01')->translatedFormat('F Y'),
            default => Carbon::parse($period)->format('d M Y'),
        };
    }

    /**
     * Get activity log report.
     */
    public function getActivityReport(array $filters = []): Collection
    {
        $query = ActivityLog::with('user:id,name')
            ->orderBy('created_at', 'desc');

        // Filter by user
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        // Filter by action
        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        // Filter by date range
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('created_at', [
                Carbon::parse($filters['start_date'])->startOfDay(),
                Carbon::parse($filters['end_date'])->endOfDay(),
            ]);
        }

        // Limit
        $limit = $filters['limit'] ?? 100;
        $query->limit($limit);

        return $query->get();
    }

    /**
     * Get dashboard statistics for admin.
     */
    public function getDashboardStats(): array
    {
        $today = now()->startOfDay();
        $thisMonth = now()->startOfMonth();

        return [
            'total_users' => User::where('role', 'user')->count(),
            'active_users' => User::where('role', 'user')->where('is_active', true)->count(),
            'total_quizzes' => Quiz::where('status', '!=', 'draft')->count(),
            'active_quizzes' => Quiz::where('status', 'active')->count(),
            'total_attempts' => Result::whereNotNull('completed_at')->count(),
            'attempts_today' => Result::whereNotNull('completed_at')
                ->whereDate('completed_at', $today)
                ->count(),
            'attempts_this_month' => Result::whereNotNull('completed_at')
                ->where('completed_at', '>=', $thisMonth)
                ->count(),
            'avg_score_overall' => round(Result::whereNotNull('completed_at')->avg('percentage') ?? 0, 1),
            'pass_rate_overall' => $this->calculateOverallPassRate(),
        ];
    }

    /**
     * Calculate overall pass rate.
     */
    private function calculateOverallPassRate(): float
    {
        $totalAttempts = Result::whereNotNull('completed_at')->count();
        if ($totalAttempts === 0) {
            return 0;
        }

        $passedCount = Result::whereNotNull('completed_at')->where('is_passed', true)->count();
        return round(($passedCount / $totalAttempts) * 100, 1);
    }
}
