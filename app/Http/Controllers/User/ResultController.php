<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Quiz;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ResultController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function index()
    {
        $results = auth()->user()->results()
            ->with('quiz')
            ->latest()
            ->paginate(10);

        return view('user.results.index', compact('results'));
    }

    public function show(Result $result)
    {
        // Make sure user can only see their own results
        if ($result->user_id !== auth()->id()) {
            abort(403);
        }

        $result->load([
            'quiz.questions.options',
            'user.answers' => function ($query) use ($result) {
                $query->whereHas('question', function ($q) use ($result) {
                    $q->where('quiz_id', $result->quiz_id);
                })->with(['question', 'option']);
            }
        ]);

        return view('user.results.show', compact('result'));
    }

    public function leaderboard(Quiz $quiz = null)
    {
        if ($quiz) {
            $leaderboard = $this->quizService->getLeaderboard($quiz, 50);
            $title = 'Leaderboard - ' . $quiz->title;
        } else {
            $leaderboard = $this->quizService->getGlobalLeaderboard(50);
            $title = 'Leaderboard Global';
        }

        $quizzes = Quiz::where('status', 'active')->get();

        return view('user.results.leaderboard', compact('leaderboard', 'title', 'quiz', 'quizzes'));
    }

    public function exportPdf(Result $result)
    {
        // Security: only allow users to download their own results
        if ($result->user_id !== auth()->id()) {
            abort(403);
        }

        $result->load(['user', 'quiz.questions.options']);

        $pdf = Pdf::loadView('admin.results.individual_pdf', compact('result'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Sertifikat_Hasil_' . \Illuminate\Support\Str::slug($result->quiz->title) . '.pdf');
    }
}
