<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions', 'results')
            ->latest()
            ->paginate(10);

        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Quiz::create($request->all());

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Kuis berhasil dibuat.');
    }

    public function show(Quiz $quiz)
    {
        $quiz->load(['questions.options', 'results.user']);

        return view('admin.quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $quiz->update($request->all());

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Kuis berhasil diperbarui.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Kuis berhasil dihapus.');
    }

    public function toggleStatus(Quiz $quiz)
    {
        $quiz->update([
            'status' => $quiz->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->back()
            ->with('success', 'Status kuis berhasil diubah.');
    }
}
