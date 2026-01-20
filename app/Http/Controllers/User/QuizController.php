<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Result;
use App\Models\QuizSession;
use App\Models\QuizProgress;
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

    public function join(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string',
        ]);

        $code = $request->access_code;

        // Find quiz by access_password (treating it as access code)
        // We only check active quizzes
        $quiz = Quiz::where('access_password', $code)
            ->where('status', 'active')
            ->first();

        if (!$quiz) {
            return redirect()->back()
                ->with('error', 'Kode kuis tidak valid atau kuis tidak ditemukan.');
        }

        // Check availability logic
        if (!$quiz->isAvailable()) {
            return redirect()->back()
                ->with('error', 'Kuis belum dimulai atau sudah berakhir.');
        }

        // Redirect to quiz detail
        return redirect()->route('user.quizzes.show', $quiz)
            ->with('success', 'Berhasil bergabung ke kuis!');
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

        // Get all questions and shuffle them for this user
        $questions = $quiz->questions()->with('options')->get();

        if ($questions->isEmpty()) {
            return redirect()->route('user.quizzes.index')
                ->with('error', 'Kuis ini belum memiliki soal.');
        }

        // Shuffle questions and store order in session
        $shuffledIds = $questions->pluck('id')->shuffle()->toArray();
        session(['quiz_' . $quiz->id . '_order' => $shuffledIds]);

        // Find first unanswered question
        $answeredQuestionIds = Answer::where('user_id', auth()->id())
            ->whereIn('question_id', $shuffledIds)
            ->pluck('question_id')
            ->toArray();

        $firstUnansweredIndex = 0;
        foreach ($shuffledIds as $index => $id) {
            if (!in_array($id, $answeredQuestionIds)) {
                $firstUnansweredIndex = $index;
                break;
            }
        }

        session(['quiz_' . $quiz->id . '_current_index' => $firstUnansweredIndex]);

        // Get the question
        $questionId = $shuffledIds[$firstUnansweredIndex];
        $question = $questions->firstWhere('id', $questionId);

        // CREATE RESULT TO MARK START TIME (DATABASE-BASED TIMER)
        Result::firstOrCreate([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id
        ]);

        $remainingSeconds = $quiz->duration * 60;
        $currentIndex = $firstUnansweredIndex;
        $totalQuestions = count($shuffledIds);

        // Monitoring: Start Session (Create QuizSession & QuizProgress)
        try {
            $this->quizService->startQuiz($quiz, auth()->user());
        } catch (\Exception $e) {
            // Ignore error if already started
        }

        return view('user.quizzes.take', compact('quiz', 'question', 'remainingSeconds', 'currentIndex', 'totalQuestions'));
    }

    public function submitAnswer(Request $request, Quiz $quiz, Question $question)
    {
        $request->validate([
            'option_id' => 'required|exists:options,id',
        ]);

        // Calculate correctness and score
        $option = \App\Models\Option::find($request->option_id);
        $isCorrect = $option && $option->is_correct;
        $scoreObtained = $isCorrect ? $question->score : 0;

        // Monitoring: Update Progress
        $session = QuizSession::where('user_id', auth()->id())
            ->where('quiz_id', $quiz->id)
            ->where('status', 'in_progress')
            ->first();

        // Save answer
        Answer::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'question_id' => $question->id,
                'session_id' => $session ? $session->id : null,
            ],
            [
                'option_id' => $request->option_id,
                'is_correct' => $isCorrect,
                'score_obtained' => $scoreObtained,
                'answered_at' => now(),
            ]
        );

        if ($session) {
            $session->update([
                'current_question_index' => Answer::where('user_id', auth()->id())
                    ->where('session_id', $session->id)
                    ->count(),
                'last_this_activity_at' => now(),
            ]);

            QuizProgress::where('session_id', $session->id)
                ->where('question_id', $question->id)
                ->update(['status' => 'answered', 'visited_at' => now()]);
        }

        // Get shuffled order from session
        $shuffledIds = session('quiz_' . $quiz->id . '_order', []);
        $currentIndex = session('quiz_' . $quiz->id . '_current_index', 0);

        // Move to next question
        $nextIndex = $currentIndex + 1;

        if ($nextIndex < count($shuffledIds)) {
            // Save next index to session
            session(['quiz_' . $quiz->id . '_current_index' => $nextIndex]);

            $nextQuestionId = $shuffledIds[$nextIndex];
            $nextQuestion = Question::with('options')->find($nextQuestionId);

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

        // CALCULATE REMAINING TIME FROM SESSION (ROBUST)
        $sessionForTimer = QuizSession::where('user_id', auth()->id())
            ->where('quiz_id', $quiz->id)
            ->where('status', 'in_progress')
            ->first();

        $startTime = $sessionForTimer ? $sessionForTimer->started_at : now();
        $remainingSeconds = $quiz->duration * 60;

        if ($sessionForTimer) {
            // Use timestamps for absolute safety to prevent timezone/carbon diff quirks
            $nowTs = now()->timestamp;
            $startTs = $sessionForTimer->started_at->timestamp;
            $elapsedSeconds = $nowTs - $startTs;

            // If elapsed is negative (clock skew), treat as 0
            $elapsedSeconds = max(0, $elapsedSeconds);

            $remainingSeconds = (int) max(0, ($quiz->duration * 60) - $elapsedSeconds);

            // IF TIME EXPIRED, AUTO FINISH
            if ($remainingSeconds <= 0) {
                return redirect()->route('user.quizzes.finish', $quiz);
            }
        }

        // Get progress
        $progress = $this->quizService->getUserProgress(auth()->user(), $quiz);

        // Get current index from session
        $shuffledIds = session('quiz_' . $quiz->id . '_order', []);
        $currentIndex = array_search($question->id, $shuffledIds);
        if ($currentIndex === false) {
            $currentIndex = 0;
        }
        $totalQuestions = count($shuffledIds) ?: $quiz->questions()->count();

        return view('user.quizzes.take', compact('quiz', 'question', 'userAnswer', 'progress', 'remainingSeconds', 'currentIndex', 'totalQuestions'));
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

        // Monitoring: Finish Session
        $session = QuizSession::where('user_id', auth()->id())
            ->where('quiz_id', $quiz->id)
            ->where('status', 'in_progress')
            ->first();

        if ($session) {
            $session->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);
        }

        return redirect()->route('user.results.show', $result)
            ->with('success', 'Kuis selesai! Lihat hasil Anda di bawah.');
    }
    public function logViolation(Quiz $quiz, Request $request)
    {
        $session = QuizSession::where('user_id', auth()->id())
            ->where('quiz_id', $quiz->id)
            ->where('status', 'in_progress')
            ->first();

        if ($session) {
            $session->increment('tab_switches');
            $session->update(['last_this_activity_at' => now()]);
        }
        return response()->json(['status' => 'ok']);
    }

    public function checkStatus(Quiz $quiz)
    {
        $session = QuizSession::where('user_id', auth()->id())
            ->where('quiz_id', $quiz->id)
            ->where('status', 'in_progress')
            ->first();

        if (!$session) {
            $kickedSession = QuizSession::where('user_id', auth()->id())
                ->where('quiz_id', $quiz->id)
                ->whereIn('status', ['kicked', 'timeout'])
                ->latest()
                ->first();

            if ($kickedSession) {
                return response()->json([
                    'status' => $kickedSession->status,
                    'reason' => $kickedSession->kick_reason
                ]);
            }
            return response()->json(['status' => 'finished']);
        }

        $lastActivity = $session->last_this_activity_at ? \Carbon\Carbon::parse($session->last_this_activity_at) : $session->updated_at;

        if ($lastActivity->diffInMinutes(now()) >= 10) {
            $session->update([
                'status' => 'timeout',
                'completed_at' => now(),
                'kick_reason' => 'Tidak aktif selama lebih dari 10 menit.'
            ]);

            // Auto-calculate result for timeout sessions
            $startTime = $session->started_at ?? now();
            $completionTime = now()->diffInSeconds($startTime);
            $this->quizService->calculateResult($session->user, $session->quiz, $completionTime);

            return response()->json(['status' => 'timeout']);
        }

        return response()->json(['status' => 'ok']);
    }
}
