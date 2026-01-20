<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizSession;
use App\Services\QuizService;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function index()
    {
        // Get quizzes with active sessions
        $activeQuizzes = Quiz::whereHas('sessions', function ($q) {
            $q->where('status', 'in_progress');
        })
            ->withCount([
                'sessions as active_count' => function ($q) {
                    $q->where('status', 'in_progress');
                }
            ])
            ->get();

        // Get all active sessions
        $activeSessions = QuizSession::where('status', 'in_progress')
            ->with(['user:id,name,email,avatar', 'quiz:id,title,duration', 'progress'])
            ->orderBy('started_at', 'desc')
            ->get();

        if (request()->ajax()) {
            return view('superadmin.monitor._session_list', compact('activeSessions'));
        }

        return view('superadmin.monitor.index', compact('activeQuizzes', 'activeSessions'));
    }

    public function quiz(Quiz $quiz)
    {
        $progressData = $this->quizService->getRealtimeProgress($quiz);

        return view('superadmin.monitor.quiz', [
            'quiz' => $quiz,
            'progressData' => $progressData,
        ]);
    }

    public function getProgress(Quiz $quiz)
    {
        $progressData = $this->quizService->getRealtimeProgress($quiz);

        return response()->json($progressData);
    }
}
