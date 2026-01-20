<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizLeaderboard;
use App\Models\Result;
use App\Services\QuizService;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function index(Request $request)
    {
        $quizzes = Quiz::where('status', 'active')
            ->withCount('results')
            ->orderBy('title')
            ->get();

        $selectedQuiz = null;
        $leaderboard = [];

        if ($request->filled('quiz_id')) {
            $selectedQuiz = Quiz::find($request->quiz_id);
            if ($selectedQuiz) {
                $leaderboard = $this->quizService->getLeaderboard($selectedQuiz, 50);
            }
        }

        // Global leaderboard
        $globalLeaderboard = Result::selectRaw('user_id, SUM(total_score) as total_score, COUNT(*) as quiz_count, AVG(percentage) as avg_percentage')
            ->with('user:id,name,email,avatar')
            ->whereNotNull('completed_at')
            ->groupBy('user_id')
            ->orderBy('total_score', 'desc')
            ->limit(20)
            ->get();

        return view('superadmin.leaderboard.index', compact(
            'quizzes',
            'selectedQuiz',
            'leaderboard',
            'globalLeaderboard'
        ));
    }

    public function recalculate(Quiz $quiz)
    {
        QuizLeaderboard::recalculate($quiz->id);

        return back()->with('success', 'Leaderboard berhasil diperbarui!');
    }
}
