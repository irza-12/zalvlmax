<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Result;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        // Get all active quizzes with results
        $quizzes = Quiz::where('status', 'active')
            ->withCount('results')
            ->has('results')
            ->get();

        // Selected quiz (if filtering)
        $selectedQuiz = null;
        $leaderboard = collect();

        if ($request->has('quiz_id') && $request->quiz_id) {
            $selectedQuiz = Quiz::find($request->quiz_id);

            if ($selectedQuiz) {
                $leaderboard = Result::where('quiz_id', $selectedQuiz->id)
                    ->whereNotNull('completed_at')
                    ->with('user')
                    ->orderBy('total_score', 'desc')
                    ->orderBy('completion_time', 'asc')
                    ->limit(50)
                    ->get()
                    ->map(function ($result, $index) {
                        return [
                            'rank' => $index + 1,
                            'user' => $result->user,
                            'score' => $result->total_score,
                            'percentage' => $result->percentage,
                            'completion_time' => $result->completion_time,
                        ];
                    });
            }
        }

        // Global leaderboard (aggregate of all quizzes)
        $globalLeaderboard = Result::selectRaw('user_id, SUM(total_score) as total_score, COUNT(*) as quiz_count, AVG(percentage) as avg_percentage')
            ->whereNotNull('completed_at')
            ->groupBy('user_id')
            ->with('user')
            ->orderBy('total_score', 'desc')
            ->limit(10)
            ->get();

        return view('user.leaderboard.index', compact('quizzes', 'selectedQuiz', 'leaderboard', 'globalLeaderboard'));
    }
}
