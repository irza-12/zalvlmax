<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Result;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function index()
    {
        $activeQuizzes = Quiz::where('status', 'active')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->withCount('questions')
            ->latest()
            ->get();

        $upcomingQuizzes = Quiz::where('status', 'active')
            ->where('start_time', '>', now())
            ->withCount('questions')
            ->orderBy('start_time')
            ->get();

        return view('user.quizzes.index', compact('activeQuizzes', 'upcomingQuizzes'));
    }

    public function show(Quiz $quiz)
    {
        if (!$quiz->isAvailable()) {
            return redirect()->route('user.quizzes.index')
                ->with('error', 'Kuis tidak tersedia saat ini.');
        }

        // Check if user already completed this quiz
        if ($this->quizService->hasUserTakenQuiz(auth()->user(), $quiz)) {
            return redirect()->route('user.results.show', [
                'result' => auth()->user()->results()->where('quiz_id', $quiz->id)->first()
            ])->with('info', 'Anda sudah mengerjakan kuis ini.');
        }

        $quiz->load('questions');

        return view('user.quizzes.show', compact('quiz'));
    }

    public function start(Quiz $quiz)
    {
        if (!$quiz->isAvailable()) {
            return redirect()->route('user.quizzes.index')
                ->with('error', 'Kuis tidak tersedia saat ini.');
        }

        // Check if user already completed this quiz
        if ($this->quizService->hasUserTakenQuiz(auth()->user(), $quiz)) {
            return redirect()->route('user.quizzes.index')
                ->with('error', 'Anda sudah mengerjakan kuis ini.');
        }

        // Get first question
        $question = $quiz->questions()->with('options')->first();

        if (!$question) {
            return redirect()->route('user.quizzes.index')
                ->with('error', 'Kuis ini belum memiliki soal.');
        }

        // CREATE RESULT TO MARK START TIME (DATABASE-BASED TIMER)
        // This sets created_at to NOW().
        Result::firstOrCreate([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id
        ]);

        $remainingSeconds = $quiz->duration * 60;

        return view('user.quizzes.take', compact('quiz', 'question', 'remainingSeconds'));
    }

    public function submitAnswer(Request $request, Quiz $quiz, Question $question)
    {
        $request->validate([
            'option_id' => 'required|exists:options,id',
        ]);

        // Save answer
        Answer::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'question_id' => $question->id,
            ],
            [
                'option_id' => $request->option_id,
            ]
        );

        // Get next question
        $nextQuestion = $quiz->questions()
            ->where('id', '>', $question->id)
            ->with('options')
            ->first();

        if ($nextQuestion) {
            return redirect()->route('user.quizzes.question', [
                'quiz' => $quiz,
                'question' => $nextQuestion
            ]);
        }

        // No more questions, finish quiz
        return redirect()->route('user.quizzes.finish', $quiz);
    }

    public function question(Quiz $quiz, Question $question)
    {
        if (!$quiz->isAvailable()) {
            return redirect()->route('user.quizzes.index')
                ->with('error', 'Kuis tidak tersedia saat ini.');
        }

        // Check if question belongs to quiz
        if ($question->quiz_id !== $quiz->id) {
            abort(404);
        }

        $question->load('options');

        // Get user's previous answer if exists
        $userAnswer = Answer::where('user_id', auth()->id())
            ->where('question_id', $question->id)
            ->first();

        // CALCULATE REMAINING TIME FROM DATABASE (ROBUST)
        $result = Result::where('user_id', auth()->id())
            ->where('quiz_id', $quiz->id)
            ->first();

        $startTime = $result ? $result->created_at : now();
        $remainingSeconds = $quiz->duration * 60;

        if ($result) {
            $elapsedSeconds = now()->diffInSeconds($startTime);
            $remainingSeconds = max(0, ($quiz->duration * 60) - $elapsedSeconds);

            // IF TIME EXPIRED, AUTO FINISH
            if ($remainingSeconds <= 0) {
                return redirect()->route('user.quizzes.finish', $quiz);
            }
        }

        // Get progress
        $progress = $this->quizService->getUserProgress(auth()->user(), $quiz);

        return view('user.quizzes.take', compact('quiz', 'question', 'userAnswer', 'progress', 'remainingSeconds'));
    }

    public function finish(Quiz $quiz)
    {
        // Get start time from database result
        $existingResult = Result::where('user_id', auth()->id())
            ->where('quiz_id', $quiz->id)
            ->first();

        $startTime = $existingResult ? $existingResult->created_at : now();
        $completionTime = now()->diffInSeconds($startTime);

        // Calculate result
        $result = $this->quizService->calculateResult(auth()->user(), $quiz, $completionTime);

        return redirect()->route('user.results.show', $result)
            ->with('success', 'Kuis selesai! Lihat hasil Anda di bawah.');
    }
}
