<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Result;
use App\Services\QuizService;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function index(Request $request)
    {
        $query = Result::with(['user', 'quiz']);

        // Filter by quiz
        if ($request->has('quiz_id') && $request->quiz_id) {
            $query->where('quiz_id', $request->quiz_id);
        }

        // Filter by user
        if ($request->has('search') && $request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $results = $query->latest()->paginate(15);
        $quizzes = Quiz::all();

        return view('admin.results.index', compact('results', 'quizzes'));
    }

    public function show(Result $result)
    {
        $result->load([
            'user',
            'quiz.questions.options',
            'user.answers' => function ($query) use ($result) {
                $query->whereHas('question', function ($q) use ($result) {
                    $q->where('quiz_id', $result->quiz_id);
                })->with(['question', 'option']);
            }
        ]);

        return view('admin.results.show', compact('result'));
    }

    public function leaderboard(Request $request)
    {
        $quizzes = Quiz::all();
        $quiz = null;
        $leaderboard = collect([]);

        if ($request->has('quiz_id') && $request->quiz_id) {
            $quiz = Quiz::find($request->quiz_id);
            if ($quiz) {
                $leaderboard = $this->quizService->getLeaderboard($quiz, 50);
            }
        }

        return view('admin.results.leaderboard', compact('quizzes', 'quiz', 'leaderboard'));
    }

    public function exportExcel(Request $request)
    {
        $results = Result::with(['user', 'quiz']);

        if ($request->has('quiz_id') && $request->quiz_id) {
            $results->where('quiz_id', $request->quiz_id);
        }

        if ($request->has('result_id')) {
            $results->where('id', $request->result_id);
        }

        $results = $results->get();

        // Manual Excel generation using simple HTML table
        $filename = 'hasil_evaluasi_' . date('Y-m-d_His') . '.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Nama Peserta</th>';
        echo '<th>Email</th>';
        echo '<th>Kuis</th>';
        echo '<th>Total Skor</th>';
        echo '<th>Jawaban Benar</th>';
        echo '<th>Jawaban Salah</th>';
        echo '<th>Waktu Pengerjaan</th>';
        echo '<th>Tanggal</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($results as $index => $result) {
            echo '<tr>';
            echo '<td>' . ($index + 1) . '</td>';
            echo '<td>' . $result->user->name . '</td>';
            echo '<td>' . $result->user->email . '</td>';
            echo '<td>' . $result->quiz->title . '</td>';
            echo '<td>' . $result->total_score . '</td>';
            echo '<td>' . $result->correct_answers . '</td>';
            echo '<td>' . $result->wrong_answers . '</td>';
            echo '<td>' . $result->formatted_completion_time . '</td>';
            echo '<td>' . $result->created_at->format('d/m/Y H:i') . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        exit;
    }

    public function exportPdf(Request $request)
    {
        $results = Result::with(['user', 'quiz']);

        if ($request->has('quiz_id') && $request->quiz_id) {
            $results->where('quiz_id', $request->quiz_id);
        }

        if ($request->has('result_id')) {
            $results->where('id', $request->result_id);
        }

        $results = $results->get();

        return view('admin.results.pdf', compact('results'));
    }

    public function compare(Request $request)
    {
        try {
            $data = $this->getComparisonData($request->ids);
            return view('admin.results.compare', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function compareExportExcel(Request $request)
    {
        try {
            $data = $this->getComparisonData($request->ids);

            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=Komparasi_Jawaban_" . now()->format('Ymd_His') . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");

            return view('admin.results.compare_export', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function compareExportPdf(Request $request)
    {
        try {
            $data = $this->getComparisonData($request->ids);
            return view('admin.results.compare_pdf', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function getComparisonData($ids)
    {
        if (!$ids || !is_array($ids) || count($ids) < 2) {
            throw new \Exception('Pilih minimal 2 hasil evaluasi untuk dibandingkan.');
        }

        $results = Result::with(['user', 'quiz.questions.options'])
            ->whereIn('id', $ids)
            ->get();

        if ($results->count() < count($ids)) {
            throw new \Exception('Beberapa data tidak ditemukan.');
        }

        $quizId = $results->first()->quiz_id;
        if ($results->unique('quiz_id')->count() > 1) {
            throw new \Exception('Hanya bisa membandingkan hasil dari kuis yang sama.');
        }

        $quiz = $results->first()->quiz;

        foreach ($results as $result) {
            $result->load([
                'user.answers' => function ($query) use ($quizId) {
                    $query->whereHas('question', function ($q) use ($quizId) {
                        $q->where('quiz_id', $quizId);
                    });
                }
            ]);
        }

        return compact('results', 'quiz');
    }
}
