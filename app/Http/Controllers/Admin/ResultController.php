<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Result;
use App\Models\QuizSession;
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

        $quizTitle = 'Semua Kuis';
        if ($request->has('quiz_id') && $request->quiz_id) {
            $results->where('quiz_id', $request->quiz_id);
            $quiz = Quiz::find($request->quiz_id);
            $quizTitle = $quiz ? $quiz->title : 'Semua Kuis';
        }

        if ($request->has('result_id')) {
            $results->where('id', $request->result_id);
        }

        // Filter by search
        if ($request->has('search') && $request->search) {
            $results->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $results = $results->get();

        $filename = 'Laporan_Evaluasi_Utama_' . date('Ymd_His') . '.xls';

        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Add BOM for UTF-8
        echo "\xEF\xBB\xBF";
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <style>
                .title {
                    font-size: 20px;
                    font-weight: bold;
                    text-align: center;
                    height: 45px;
                    vertical-align: middle;
                    border: none;
                }

                .meta-label {
                    background-color: #f1f5f9;
                    font-weight: bold;
                    border: 1px solid #000000;
                    padding: 5px;
                    font-size: 12px;
                }

                .meta-value {
                    border: 1px solid #000000;
                    padding: 5px;
                    font-size: 12px;
                }

                .header-cell {
                    background-color: #1e3a8a;
                    color: #ffffff;
                    font-weight: bold;
                    text-align: center;
                    border: 1px solid #000000;
                    height: 30px;
                    vertical-align: middle;
                }

                .data-cell {
                    border: 1px solid #000000;
                    padding: 8px;
                    vertical-align: middle;
                }

                .center {
                    text-align: center;
                }

                .pass {
                    color: #059669;
                    font-weight: bold;
                }

                .fail {
                    color: #dc2626;
                    font-weight: bold;
                }
            </style>
        </head>

        <body>
            <table border="1">
                <tr>
                    <td colspan="10" class="title" style="border:none;">LAPORAN HASIL EVALUASI PESERTA</td>
                </tr>
                <tr>
                    <td colspan="10" style="text-align: center; font-size: 12px; color: #64748b; border:none;">Aplikasi:
                        <?php echo config('app.name'); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="10" style="border:none;"></td>
                </tr>

                <tr>
                    <td colspan="2" class="meta-label">Mata Ujian:</td>
                    <td colspan="8" class="meta-value"><?php echo $quizTitle; ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="meta-label">Tanggal Cetak:</td>
                    <td colspan="8" class="meta-value"><?php echo date('d F Y, H:i'); ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="meta-label">Total Peserta:</td>
                    <td colspan="8" class="meta-value"><?php echo $results->count(); ?> Orang</td>
                </tr>
                <tr>
                    <td colspan="10" style="border:none;"></td>
                </tr>

                <thead>
                    <tr>
                        <th class="header-cell" width="50" style="background-color: #1e3a8a; color: #ffffff;">NO</th>
                        <th class="header-cell" width="200" style="background-color: #1e3a8a; color: #ffffff;">NAMA PESERTA</th>
                        <th class="header-cell" width="250" style="background-color: #1e3a8a; color: #ffffff;">EMAIL</th>
                        <th class="header-cell" width="300" style="background-color: #1e3a8a; color: #ffffff;">NAMA KUIS</th>
                        <th class="header-cell" width="80" style="background-color: #1e3a8a; color: #ffffff;">SKOR</th>
                        <th class="header-cell" width="80" style="background-color: #1e3a8a; color: #ffffff;">AKURASI</th>
                        <th class="header-cell" width="80" style="background-color: #1e3a8a; color: #ffffff;">BENAR</th>
                        <th class="header-cell" width="80" style="background-color: #1e3a8a; color: #ffffff;">SALAH</th>
                        <th class="header-cell" width="120" style="background-color: #1e3a8a; color: #ffffff;">DURASI</th>
                        <th class="header-cell" width="150" style="background-color: #1e3a8a; color: #ffffff;">TANGGAL</th>
                        <th class="header-cell" width="120" style="background-color: #1e3a8a; color: #ffffff;">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $index => $result): ?>
                        <tr>
                            <td class="data-cell center"><?php echo $index + 1; ?></td>
                            <td class="data-cell"><?php echo strtoupper($result->user->name); ?></td>
                            <td class="data-cell"><?php echo $result->user->email; ?></td>
                            <td class="data-cell"><?php echo $result->quiz->title; ?></td>
                            <td class="data-cell center" style="font-weight: bold;"><?php echo floatval($result->total_score); ?>
                            </td>
                            <td class="data-cell center" style="font-weight: bold; color: #2563eb;">
                                <?php echo $result->percentage; ?>%
                            </td>
                            <td class="data-cell center" style="color: #059669;"><?php echo $result->correct_answers; ?></td>
                            <td class="data-cell center" style="color: #dc2626;"><?php echo $result->wrong_answers; ?></td>
                            <td class="data-cell center"><?php echo $result->formatted_completion_time; ?></td>
                            <td class="data-cell center"><?php echo $result->created_at->format('d/m/Y H:i'); ?></td>
                            <td class="data-cell center <?php echo $result->is_passed ? 'pass' : 'fail'; ?>">
                                <?php echo $result->is_passed ? 'LULUS' : 'TIDAK LULUS'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </body>

        </html>
        <?php
        exit;
    }

    public function exportPdf(Request $request)
    {
        // Support individual session export (for in-progress/specific users)
        if ($request->has('session_id')) {
            $session = QuizSession::with(['user', 'quiz', 'result', 'answers.question.options'])->find($request->session_id);
            if ($session) {
                $result = $session->result;
                if (!$result) {
                    // Create temporary Result object for preview
                    $result = new Result();
                    $result->user = $session->user;
                    $result->quiz = $session->quiz;
                    $result->percentage = $session->progress_percentage;
                    $result->correct_answers = $session->answers->where('is_correct', true)->count();
                    $result->wrong_answers = $session->answers->where('is_correct', false)->count();
                    $result->completion_time = $session->elapsed_time;
                    $result->is_passed = $result->percentage >= ($session->quiz->passing_score ?? 70);
                    $result->created_at = $session->started_at;
                }

                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.results.individual_pdf', compact('result'));
                $pdf->setPaper('a4', 'portrait');
                return $pdf->stream('Evaluasi_' . \Illuminate\Support\Str::slug($session->user->name) . '.pdf');
            }
        }

        $results = Result::with(['user', 'quiz']);

        $quizTitle = 'Semua Kuis';
        if ($request->has('quiz_id') && $request->quiz_id) {
            $results->where('quiz_id', $request->quiz_id);
            $quiz = Quiz::find($request->quiz_id);
            $quizTitle = $quiz ? $quiz->title : 'Semua Kuis';
        }

        if ($request->has('result_id')) {
            $results->where('id', $request->result_id);
        }

        // Filter by search
        if ($request->has('search') && $request->search) {
            $results->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $results = $results->get();

        if ($request->has('result_id') && $results->count() === 1) {
            $result = $results->first();
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.results.individual_pdf', compact('result'));
            $pdf->setPaper('a4', 'portrait');
            return $pdf->stream('Sertifikat_' . \Illuminate\Support\Str::slug($result->user->name) . '.pdf');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.results.pdf', compact('results', 'quizTitle'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan_Evaluasi.pdf');
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
