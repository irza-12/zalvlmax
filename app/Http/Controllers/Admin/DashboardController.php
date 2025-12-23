<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Result;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalQuizzes = Quiz::count();
        $totalParticipants = User::where('role', 'user')->count();
        $averageScore = Result::avg('total_score') ?? 0;
        $totalAttempts = Result::count();

        // Get recent results for chart
        $recentResults = Result::with(['user', 'quiz'])
            ->latest()
            ->limit(10)
            ->get();

        // Get quiz statistics
        $quizStats = Quiz::withCount('results')
            ->with([
                'results' => function ($query) {
                    $query->selectRaw('quiz_id, AVG(total_score) as avg_score')
                        ->groupBy('quiz_id');
                }
            ])
            ->get();

        // Get top performers
        $topPerformers = Result::with('user')
            ->selectRaw('user_id, SUM(total_score) as total_score, COUNT(*) as quiz_count')
            ->groupBy('user_id')
            ->orderBy('total_score', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalQuizzes',
            'totalParticipants',
            'averageScore',
            'totalAttempts',
            'recentResults',
            'quizStats',
            'topPerformers'
        ));
    }
}
