<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:multiple_choice,multiple_correct,true_false',
            'score' => 'required|integer|min:0',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string',
            'correct_option' => 'required', // index or key
        ]);

        try {
            DB::beginTransaction();

            $question = $quiz->questions()->create([
                'question_text' => $validated['question_text'],
                'type' => $validated['type'],
                'score' => $validated['score'],
            ]);

            foreach ($validated['options'] as $key => $optionData) {
                // Determine if this option is correct
                // For radio buttons, correct_option might be the index '0', '1', etc.
                // We need to handle this carefully.
                $isCorrect = false;
                if ($validated['type'] === 'multiple_choice' || $validated['type'] === 'true_false') {
                    $isCorrect = ($validated['correct_option'] == $key);
                } elseif ($validated['type'] === 'multiple_correct') {
                    // For multiple correct, correct_option might be an array
                    $isCorrect = is_array($validated['correct_option']) && in_array($key, $validated['correct_option']);
                }

                $question->options()->create([
                    'option_text' => $optionData['text'],
                    'is_correct' => $isCorrect,
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Soal berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan soal: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'score' => 'required|integer|min:0',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string',
            'correct_option' => 'required', // ID of the correct option
        ]);

        try {
            DB::beginTransaction();

            $question->update([
                'question_text' => $validated['question_text'],
                'score' => $validated['score'],
            ]);

            // Update Options
            // We expect options array keys to be the Option IDs
            foreach ($validated['options'] as $optionId => $optionData) {
                // Ensure the option belongs to this question
                $option = $question->options()->find($optionId);

                if ($option) {
                    $isCorrect = ($validated['correct_option'] == $optionId);
                    $option->update([
                        'option_text' => $optionData['text'],
                        'is_correct' => $isCorrect
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Soal berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal update soal: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        try {
            $question->delete();
            return redirect()->back()->with('success', 'Soal berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus soal');
        }
    }
}
