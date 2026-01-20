<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizSession;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    /**
     * Export individual session evaluation as PDF.
     */
    public function exportPdf(QuizSession $session)
    {
        // Load necessary relationships
        $session->load(['user', 'quiz', 'result', 'answers.question.options', 'answers.option']);

        // Generate PDF using the Blade view
        $pdf = Pdf::loadView('superadmin.reports.pdf.evaluation', [
            'session' => $session,
            'result' => $session->result
        ]);

        // Setup filename
        $filename = 'Evaluasi-' . \Illuminate\Support\Str::slug($session->user->name) . '-' . $session->created_at->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export all sessions PDF as a combined report.
     */
    public function exportPdfAll(Quiz $quiz)
    {
        // Get all completed sessions for this quiz with proper relationships
        $sessions = $quiz->sessions()
            ->with(['user', 'result', 'answers.question.options', 'answers.option'])
            ->get();

        if ($sessions->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada peserta yang menyelesaikan kuis ini.');
        }

        // Generate PDF - view expects $sessions variable
        $pdf = Pdf::loadView('superadmin.reports.pdf.evaluation-all', [
            'quiz' => $quiz,
            'sessions' => $sessions
        ]);

        // Setup filename
        $filename = 'Laporan-Lengkap-' . \Illuminate\Support\Str::slug($quiz->title) . '-' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
    }


    /**
     * Export quiz statistics/leaderboard as professional Excel (XLSX).
     */
    public function exportExcel(Quiz $quiz)
    {
        $fileName = 'Hasil-Kuis-' . str_replace(' ', '-', $quiz->title) . '-' . date('Ymd') . '.xls';

        // Get all COMPLETED results for this quiz
        $results = $quiz->results()
            ->with(['user', 'quiz'])
            ->orderBy('total_score', 'desc')
            ->get();

        // Calculate statistics using database is_passed for consistency
        $totalParticipants = $results->count();
        $avgScore = $totalParticipants > 0 ? round($results->avg('percentage'), 1) : 0;
        $highestScore = $totalParticipants > 0 ? round($results->max('percentage'), 1) : 0;
        $lowestScore = $totalParticipants > 0 ? round($results->min('percentage'), 1) : 0;
        $passingScore = $quiz->passing_score ?? 70;
        // Use is_passed from database for consistency
        $passedCount = $results->filter(fn($r) => $r->is_passed)->count();
        $passRate = $totalParticipants > 0 ? round(($passedCount / $totalParticipants) * 100, 1) : 0;

        // Generate HTML for Excel
        $html = $this->generateExcelHtml($quiz, $results, [
            'total' => $totalParticipants,
            'avg' => $avgScore,
            'highest' => $highestScore,
            'lowest' => $lowestScore,
            'passed' => $passedCount,
            'failed' => $totalParticipants - $passedCount,
            'passRate' => $passRate,
            'passingScore' => $passingScore
        ]);

        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        return Response::make($html, 200, $headers);
    }

    /**
     * Generate professional HTML table for Excel export.
     */
    private function generateExcelHtml(Quiz $quiz, $results, array $stats): string
    {
        $appName = config('app.name');
        $generatedAt = now()->format('d F Y H:i');

        $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0.5in; }
        body { font-family: Calibri, Arial, sans-serif; font-size: 11pt; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #333; padding: 8px; }
        .header-title { font-size: 18pt; font-weight: bold; color: #1e3a5f; text-align: center; }
        .header-subtitle { font-size: 12pt; color: #666; text-align: center; margin-bottom: 20px; }
        .section-title { font-size: 14pt; font-weight: bold; color: #1e3a5f; background-color: #e8f4f8; padding: 10px; margin: 20px 0 10px 0; }
        .stats-table th { background-color: #1e3a5f; color: white; text-align: left; }
        .stats-table td { background-color: #f8f9fa; }
        .data-table th { background-color: #2563eb; color: white; text-align: center; font-weight: bold; }
        .data-table tr:nth-child(even) { background-color: #f0f4ff; }
        .data-table tr:nth-child(odd) { background-color: #ffffff; }
        .rank-1 { background-color: #fef3c7 !important; font-weight: bold; }
        .rank-2 { background-color: #e5e7eb !important; }
        .rank-3 { background-color: #fed7aa !important; }
        .status-passed { color: #059669; font-weight: bold; }
        .status-failed { color: #dc2626; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .highlight-good { background-color: #d1fae5; }
        .highlight-avg { background-color: #fef3c7; }
        .highlight-low { background-color: #fee2e2; }
    </style>
</head>
<body>
    <!-- Header -->
    <table style="border: none; margin-bottom: 20px;">
        <tr style="border: none;">
            <td style="border: none; text-align: center;">
                <div class="header-title">📊 LAPORAN HASIL KUIS</div>
                <div class="header-subtitle">{$appName}</div>
            </td>
        </tr>
    </table>

    <!-- Quiz Information -->
    <div class="section-title">📋 Informasi Kuis</div>
    <table class="stats-table" style="width: 100%; margin-bottom: 20px;">
        <tr>
            <th style="width: 25%;">Judul Kuis</th>
            <td style="width: 75%;">{$quiz->title}</td>
        </tr>
        <tr>
            <th>Tanggal Export</th>
            <td>{$generatedAt}</td>
        </tr>
        <tr>
            <th>Passing Score</th>
            <td>{$stats['passingScore']}%</td>
        </tr>
    </table>

    <!-- Summary Statistics -->
    <div class="section-title">📈 Ringkasan Statistik</div>
    <table class="stats-table" style="width: 100%; margin-bottom: 30px;">
        <tr>
            <th style="width: 25%;">Total Peserta</th>
            <td style="width: 25%; text-align: center; font-size: 16pt; font-weight: bold;">{$stats['total']}</td>
            <th style="width: 25%;">Rata-rata Skor</th>
            <td style="width: 25%; text-align: center; font-size: 16pt; font-weight: bold;">{$stats['avg']}%</td>
        </tr>
        <tr>
            <th>Skor Tertinggi</th>
            <td style="text-align: center; font-size: 14pt; color: #059669; font-weight: bold;">{$stats['highest']}%</td>
            <th>Skor Terendah</th>
            <td style="text-align: center; font-size: 14pt; color: #dc2626; font-weight: bold;">{$stats['lowest']}%</td>
        </tr>
        <tr>
            <th>Peserta Lulus</th>
            <td style="text-align: center; color: #059669; font-weight: bold;">{$stats['passed']} orang</td>
            <th>Peserta Tidak Lulus</th>
            <td style="text-align: center; color: #dc2626; font-weight: bold;">{$stats['failed']} orang</td>
        </tr>
        <tr>
            <th>Tingkat Kelulusan</th>
            <td colspan="3" style="text-align: center; font-size: 18pt; font-weight: bold; color: #2563eb;">{$stats['passRate']}%</td>
        </tr>
    </table>

    <!-- Detailed Results -->
    <div class="section-title">🏆 Detail Hasil Peserta</div>
    <table class="data-table" style="width: 100%;">
        <thead>
            <tr>
                <th style="width: 8%;">Peringkat</th>
                <th style="width: 25%;">Nama Peserta</th>
                <th style="width: 22%;">Email</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 10%;">Durasi</th>
                <th style="width: 8%;">Skor</th>
                <th style="width: 7%;">Benar</th>
                <th style="width: 7%;">Salah</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
HTML;

        $rank = 0;
        foreach ($results as $result) {
            $rank++;
            // Use is_passed from database for consistency
            $isPassed = $result->is_passed;
            $statusText = $isPassed ? 'LULUS' : 'TIDAK LULUS';
            $statusClass = $isPassed ? 'status-passed' : 'status-failed';

            // Determine row class for top 3
            $rowClass = '';
            if ($rank === 1)
                $rowClass = 'rank-1';
            elseif ($rank === 2)
                $rowClass = 'rank-2';
            elseif ($rank === 3)
                $rowClass = 'rank-3';

            // Medal emoji for top 3
            $rankDisplay = $rank;
            if ($rank === 1)
                $rankDisplay = '🥇 1';
            elseif ($rank === 2)
                $rankDisplay = '🥈 2';
            elseif ($rank === 3)
                $rankDisplay = '🥉 3';

            $html .= <<<HTML
            <tr class="{$rowClass}">
                <td class="text-center">{$rankDisplay}</td>
                <td>{$result->user->name}</td>
                <td>{$result->user->email}</td>
                <td class="text-center">{$result->created_at->format('d/m/Y H:i')}</td>
                <td class="text-center">{$result->formatted_completion_time}</td>
                <td class="text-center" style="font-weight: bold;">{$result->percentage}%</td>
                <td class="text-center" style="color: #059669;">{$result->correct_answers}</td>
                <td class="text-center" style="color: #dc2626;">{$result->wrong_answers}</td>
                <td class="text-center {$statusClass}">{$statusText}</td>
            </tr>
HTML;
        }

        $html .= <<<HTML
        </tbody>
    </table>

    <!-- Footer -->
    <table style="border: none; margin-top: 30px;">
        <tr style="border: none;">
            <td style="border: none; text-align: center; color: #666; font-size: 9pt;">
                Dokumen ini di-generate secara otomatis oleh sistem {$appName}.<br/>
                Dicetak pada: {$generatedAt}
            </td>
        </tr>
    </table>
</body>
</html>
HTML;

        return $html;
    }
}
