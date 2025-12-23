<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalQuizzesTaken = $user->results()->count();
        $averageScore = $user->results()->avg('total_score') ?? 0;
        $totalCorrectAnswers = $user->results()->sum('correct_answers');
        $totalWrongAnswers = $user->results()->sum('wrong_answers');

        $recentResults = $user->results()
            ->with('quiz')
            ->latest()
            ->limit(5)
            ->get();

        return view('user.dashboard', compact(
            'totalQuizzesTaken',
            'averageScore',
            'totalCorrectAnswers',
            'totalWrongAnswers',
            'recentResults'
        ));
    }
}
