<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Result;
use App\Models\Category;
use App\Models\QuizSession;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_admins' => User::whereIn('role', ['admin', 'super_admin'])->count(),
            'active_users' => User::where('role', 'user')->where('is_active', true)->count(),
            'total_quizzes' => Quiz::count(),
            'active_quizzes' => Quiz::where('status', 'active')->count(),
            'total_categories' => Category::where('is_active', true)->count(),
            'total_attempts' => Result::whereNotNull('completed_at')->count(),
            'attempts_today' => Result::whereNotNull('completed_at')
                ->whereDate('completed_at', today())
                ->count(),
            'avg_score' => round(Result::whereNotNull('completed_at')->avg('percentage') ?? 0, 1),
            'active_sessions' => QuizSession::where('status', 'in_progress')->count(),
        ];

        // Recent activities
        $recentActivities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Top quizzes by attempts
        $topQuizzes = Quiz::withCount([
            'results as attempt_count' => function ($q) {
                $q->whereNotNull('completed_at');
            }
        ])
            ->withAvg('results as avg_score', 'percentage')
            ->orderBy('attempt_count', 'desc')
            ->limit(5)
            ->get();

        // Recent users
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pass rate per quiz (for chart)
        $quizStats = Quiz::where('status', 'active')
            ->withCount([
                'results as passed_count' => function ($q) {
                    $q->where('is_passed', true);
                }
            ])
            ->withCount([
                'results as total_count' => function ($q) {
                    $q->whereNotNull('completed_at');
                }
            ])
            ->limit(10)
            ->get()
            ->map(function ($quiz) {
                return [
                    'name' => $quiz->title,
                    'pass_rate' => $quiz->total_count > 0
                        ? round(($quiz->passed_count / $quiz->total_count) * 100, 1)
                        : 0,
                ];
            });

        return view('superadmin.dashboard', compact(
            'stats',
            'recentActivities',
            'topQuizzes',
            'recentUsers',
            'quizStats'
        ));
    }
}
