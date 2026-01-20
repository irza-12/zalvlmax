<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Category;
use App\Models\Question;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $query = Quiz::with('category', 'creator')
            ->withCount('questions');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $quizzes = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::where('is_active', true)->get();

        return view('superadmin.quizzes.index', compact('quizzes', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('superadmin.quizzes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'duration' => 'required|integer|min:1',
            'passing_score' => 'required|numeric|min:0|max:100',
            'max_attempts' => 'required|integer|min:1',
            'status' => 'required|in:draft,active,inactive',
            'access_password' => 'required|string|max:20',
        ]);

        $validated['uuid'] = Str::uuid();
        $validated['created_by'] = auth()->id();
        $validated['shuffle_questions'] = $request->has('shuffle_questions');
        $validated['shuffle_options'] = $request->has('shuffle_options');
        $validated['show_correct_answer'] = $request->has('show_correct_answer');
        $validated['access_type'] = 'password';

        $quiz = Quiz::create($validated);

        ActivityLog::log(ActivityLog::ACTION_CREATE, "Membuat kuis: {$quiz->title}", $quiz);

        return redirect()->route('superadmin.quizzes.edit', $quiz)
            ->with('success', 'Kuis berhasil dibuat! Silakan tambahkan soal.');
    }

    public function edit(Quiz $quiz)
    {
        $quiz->load('questions.options');
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('superadmin.quizzes.edit', compact('quiz', 'categories'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'duration' => 'required|integer|min:1',
            'passing_score' => 'required|numeric|min:0|max:100',
            'max_attempts' => 'required|integer|min:1',
            'status' => 'required|in:draft,active,inactive,archived',
            'access_password' => 'required|string|max:20',
        ]);

        $validated['shuffle_questions'] = $request->has('shuffle_questions');
        $validated['shuffle_options'] = $request->has('shuffle_options');
        $validated['show_correct_answer'] = $request->has('show_correct_answer');
        $validated['access_type'] = 'password';

        $quiz->update($validated);

        ActivityLog::log(ActivityLog::ACTION_UPDATE, "Mengupdate kuis: {$quiz->title}", $quiz);

        return back()->with('success', 'Kuis berhasil diupdate!');
    }

    public function destroy(Quiz $quiz)
    {
        $title = $quiz->title;
        $quiz->delete();

        ActivityLog::log(ActivityLog::ACTION_DELETE, "Menghapus kuis: {$title}");

        return redirect()->route('superadmin.quizzes.index')
            ->with('success', 'Kuis berhasil dihapus!');
    }

    public function duplicate(Quiz $quiz)
    {
        $newQuiz = $quiz->replicate();
        $newQuiz->uuid = Str::uuid();
        $newQuiz->title = $quiz->title . ' (Copy)';
        $newQuiz->status = 'draft';
        $newQuiz->created_by = auth()->id();
        $newQuiz->save();

        // Duplicate questions and options
        foreach ($quiz->questions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->quiz_id = $newQuiz->id;
            $newQuestion->save();

            foreach ($question->options as $option) {
                $newOption = $option->replicate();
                $newOption->question_id = $newQuestion->id;
                $newOption->save();
            }
        }

        ActivityLog::log(ActivityLog::ACTION_CREATE, "Menduplikasi kuis: {$quiz->title}", $newQuiz);

        return redirect()->route('superadmin.quizzes.edit', $newQuiz)
            ->with('success', 'Kuis berhasil diduplikasi!');
    }
}
