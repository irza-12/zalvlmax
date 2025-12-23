<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        $questions = $quiz->questions()->with('options')->paginate(10);

        return view('admin.questions.index', compact('quiz', 'questions'));
    }

    public function create(Quiz $quiz)
    {
        return view('admin.questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $validator = Validator::make($request->all(), [
            'question_text' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false,multiple_correct',
            'score' => 'required|integer|min:1',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_options' => 'required|array|min:1',
            'correct_options.*' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create question
        $question = $quiz->questions()->create([
            'question_text' => $request->question_text,
            'type' => $request->type,
            'score' => $request->score,
        ]);

        // Create options
        foreach ($request->options as $index => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct' => in_array($index, $request->correct_options),
            ]);
        }

        return redirect()->route('admin.questions.index', $quiz)
            ->with('success', 'Soal berhasil dibuat.');
    }

    public function edit(Quiz $quiz, Question $question)
    {
        $question->load('options');

        return view('admin.questions.edit', compact('quiz', 'question'));
    }

    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $validator = Validator::make($request->all(), [
            'question_text' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false,multiple_correct',
            'score' => 'required|integer|min:1',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_options' => 'required|array|min:1',
            'correct_options.*' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update question
        $question->update([
            'question_text' => $request->question_text,
            'type' => $request->type,
            'score' => $request->score,
        ]);

        // Delete old options and create new ones
        $question->options()->delete();

        foreach ($request->options as $index => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct' => in_array($index, $request->correct_options),
            ]);
        }

        return redirect()->route('admin.questions.index', $quiz)
            ->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();

        return redirect()->route('admin.questions.index', $quiz)
            ->with('success', 'Soal berhasil dihapus.');
    }
}
