<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Lengkap - {{ $quiz->title }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        .page-break {
            page-break-after: always;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header h1 {
            color: #1e293b;
            font-size: 22px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header h2 {
            color: #2563eb;
            font-size: 16px;
            margin: 5px 0 0;
            font-weight: normal;
        }

        .header p {
            color: #64748b;
            margin: 5px 0 0;
            font-size: 10px;
        }

        .summary-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            color: #0369a1;
            margin-bottom: 10px;
            border-bottom: 1px solid #7dd3fc;
            padding-bottom: 5px;
        }

        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #0369a1;
        }

        .summary-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .toc-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .toc-table th {
            background-color: #2563eb;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
        }

        .toc-table td {
            padding: 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
        }

        .toc-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }

        .status-pass {
            background: #d1fae5;
            color: #065f46;
        }

        .status-fail {
            background: #fee2e2;
            color: #991b1b;
        }

        .rank-gold {
            color: #f59e0b;
        }

        .rank-silver {
            color: #6b7280;
        }

        .rank-bronze {
            color: #b45309;
        }

        .quiz-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
        }

        .quiz-info-item {
            display: inline-block;
            margin-right: 30px;
        }

        .quiz-info-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
        }

        .quiz-info-value {
            font-size: 12px;
            font-weight: bold;
            color: #1e293b;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }

        /* Compact detail section */
        .detail-section {
            margin-top: 20px;
        }

        .participant-row {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 10px;
            padding: 10px;
            background: #fafafa;
        }

        .participant-row-header {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .participant-row-rank {
            display: table-cell;
            width: 40px;
            font-weight: bold;
            font-size: 14px;
            vertical-align: middle;
        }

        .participant-row-name {
            display: table-cell;
            vertical-align: middle;
        }

        .participant-row-name-text {
            font-weight: bold;
            font-size: 12px;
        }

        .participant-row-email {
            font-size: 9px;
            color: #64748b;
        }

        .participant-row-score {
            display: table-cell;
            width: 80px;
            text-align: right;
            vertical-align: middle;
        }

        .score-big {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }

        .meta-inline {
            font-size: 9px;
            color: #64748b;
            margin-bottom: 5px;
        }

        .answers-compact {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        .answers-compact th {
            background-color: #e2e8f0;
            padding: 4px 6px;
            text-align: left;
            font-size: 8px;
        }

        .answers-compact td {
            padding: 4px 6px;
            border-bottom: 1px solid #f1f5f9;
        }

        .correct {
            color: #059669;
            font-weight: bold;
        }

        .wrong {
            color: #dc2626;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Cover Page -->
    <div class="header">
        <h1>Laporan Lengkap Hasil Kuis</h1>
        <h2>{{ $quiz->title }}</h2>
        <p>{{ config('app.name') }} Professional Assessment Report</p>
    </div>

    <!-- Quiz Information -->
    <div class="quiz-info">
        <div class="quiz-info-item">
            <div class="quiz-info-label">Passing Score</div>
            <div class="quiz-info-value">{{ $quiz->passing_score ?? 70 }}%</div>
        </div>
        <div class="quiz-info-item">
            <div class="quiz-info-label">Jumlah Soal</div>
            <div class="quiz-info-value">{{ $quiz->questions_count ?? $quiz->questions->count() }}</div>
        </div>
        <div class="quiz-info-item">
            <div class="quiz-info-label">Durasi</div>
            <div class="quiz-info-value">{{ $quiz->duration }} Menit</div>
        </div>
        <div class="quiz-info-item">
            <div class="quiz-info-label">Tanggal Export</div>
            <div class="quiz-info-value">{{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <!-- Summary Statistics - Using database is_passed value -->
    @php
        $totalParticipants = $sessions->count();
        $sessionsWithResults = $sessions->filter(fn($s) => $s->result);
        $avgScore = $sessionsWithResults->avg(fn($s) => $s->result->percentage) ?? 0;
        $highestScore = $sessionsWithResults->max(fn($s) => $s->result->percentage) ?? 0;
        $lowestScore = $sessionsWithResults->min(fn($s) => $s->result->percentage) ?? 0;
        $passingScore = $quiz->passing_score ?? 70;
        // Use is_passed from database for consistency
        $passedCount = $sessionsWithResults->filter(fn($s) => $s->result->is_passed)->count();
        $failedCount = $totalParticipants - $passedCount;
        $passRate = $totalParticipants > 0 ? round(($passedCount / $totalParticipants) * 100, 1) : 0;
    @endphp

    <div class="summary-section">
        <div class="summary-title">📊 Ringkasan Statistik</div>
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 16.66%; text-align: center; border: none; padding: 8px;">
                    <div class="summary-value">{{ $totalParticipants }}</div>
                    <div class="summary-label">Total Peserta</div>
                </td>
                <td style="width: 16.66%; text-align: center; border: none; padding: 8px;">
                    <div class="summary-value">{{ number_format($avgScore, 1) }}%</div>
                    <div class="summary-label">Rata-rata</div>
                </td>
                <td style="width: 16.66%; text-align: center; border: none; padding: 8px;">
                    <div class="summary-value" style="color: #059669;">{{ number_format($highestScore, 1) }}%</div>
                    <div class="summary-label">Tertinggi</div>
                </td>
                <td style="width: 16.66%; text-align: center; border: none; padding: 8px;">
                    <div class="summary-value" style="color: #dc2626;">{{ number_format($lowestScore, 1) }}%</div>
                    <div class="summary-label">Terendah</div>
                </td>
                <td style="width: 16.66%; text-align: center; border: none; padding: 8px;">
                    <div class="summary-value" style="color: #059669;">{{ $passedCount }}</div>
                    <div class="summary-label">Lulus</div>
                </td>
                <td style="width: 16.66%; text-align: center; border: none; padding: 8px;">
                    <div class="summary-value" style="color: #2563eb;">{{ $passRate }}%</div>
                    <div class="summary-label">Tingkat Kelulusan</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Table of Contents / Leaderboard - All in one table -->
    <div class="summary-title" style="margin-bottom: 15px;">🏆 Daftar Peserta & Hasil</div>
    <table class="toc-table">
        <thead>
            <tr>
                <th style="width: 6%;">#</th>
                <th style="width: 22%;">Nama</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 10%;">Durasi</th>
                <th style="width: 8%;">Benar</th>
                <th style="width: 8%;">Salah</th>
                <th style="width: 8%;">Skor</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sessions->sortByDesc(fn($s) => $s->result ? $s->result->percentage : 0)->values() as $index => $session)
                @php
                    $rank = $index + 1;
                    $result = $session->result;
                    $score = $result ? $result->percentage : 0;
                    // Use is_passed from database for consistency
                    $isPassed = $result ? $result->is_passed : false;
                @endphp
                <tr>
                    <td style="font-weight: bold; {{ $rank <= 3 ? 'font-size: 12px;' : '' }}">
                        @if($rank === 1)
                            <span class="rank-gold">🥇</span>
                        @elseif($rank === 2)
                            <span class="rank-silver">🥈</span>
                        @elseif($rank === 3)
                            <span class="rank-bronze">🥉</span>
                        @else
                            {{ $rank }}
                        @endif
                    </td>
                    <td style="font-weight: {{ $rank <= 3 ? 'bold' : 'normal' }};">{{ $session->user->name }}</td>
                    <td>{{ $session->user->email }}</td>
                    <td>{{ $session->completed_at ? $session->completed_at->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $result ? $result->formatted_completion_time : '-' }}</td>
                    <td style="color: #059669; font-weight: bold;">{{ $result ? $result->correct_answers : 0 }}</td>
                    <td style="color: #dc2626; font-weight: bold;">{{ $result ? $result->wrong_answers : 0 }}</td>
                    <td
                        style="font-weight: bold; color: {{ $score >= 80 ? '#059669' : ($score >= 60 ? '#f59e0b' : '#dc2626') }};">
                        {{ number_format($score, 0) }}%
                    </td>
                    <td>
                        <span class="status-badge {{ $isPassed ? 'status-pass' : 'status-fail' }}">
                            {{ $isPassed ? 'LULUS' : 'TIDAK LULUS' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Only show detailed answers if specifically requested or limited number of participants -->
    @if($sessions->count() <= 10)
        <div class="page-break"></div>

        <div class="header" style="margin-bottom: 15px;">
            <h1 style="font-size: 16px;">Detail Jawaban Peserta</h1>
        </div>

        @foreach($sessions->sortByDesc(fn($s) => $s->result ? $s->result->percentage : 0)->values() as $index => $session)
            @php
                $rank = $index + 1;
                $result = $session->result;
                $score = $result ? $result->percentage : 0;
                $isPassed = $result ? $result->is_passed : false;
            @endphp

            <div class="participant-row">
                <div class="participant-row-header">
                    <div class="participant-row-rank">
                        #{{ $rank }}
                    </div>
                    <div class="participant-row-name">
                        <div class="participant-row-name-text">{{ $session->user->name }}</div>
                        <div class="participant-row-email">{{ $session->user->email }}</div>
                    </div>
                    <div class="participant-row-score">
                        <span class="score-big">{{ number_format($score, 0) }}%</span>
                        <span class="status-badge {{ $isPassed ? 'status-pass' : 'status-fail' }}"
                            style="display: block; margin-top: 4px;">
                            {{ $isPassed ? 'LULUS' : ($session->completed_at ? 'TIDAK LULUS' : 'PROSES') }}
                        </span>
                    </div>
                </div>

                <div class="meta-inline">
                    <strong>Mulai:</strong> {{ $session->started_at ? $session->started_at->format('d/m/Y H:i') : '-' }} |
                    <strong>Selesai:</strong>
                    {{ $session->completed_at ? $session->completed_at->format('d/m/Y H:i') : 'Dalam Proses' }} |
                    <strong>Durasi:</strong> {{ $result ? $result->formatted_completion_time : '-' }} |
                    <strong>Benar:</strong> <span style="color: #059669;">{{ $result ? $result->correct_answers : 0 }}</span> |
                    <strong>Salah:</strong> <span style="color: #dc2626;">{{ $result ? $result->wrong_answers : 0 }}</span>
                </div>

                <table class="answers-compact">
                    <thead>
                        <tr>
                            <th style="width: 4%;">No</th>
                            <th style="width: 46%;">Pertanyaan</th>
                            <th style="width: 25%;">Jawaban Peserta</th>
                            <th style="width: 20%;">Kunci</th>
                            <th style="width: 5%;">✓/✗</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($session->answers as $ansIndex => $answer)
                            @php
                                $isCorrect = $answer->is_correct;
                                $correctOption = $answer->question->options->where('is_correct', true)->first();
                            @endphp
                            <tr>
                                <td>{{ $ansIndex + 1 }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($answer->question->question_text, 50) }}</td>
                                <td>{{ $answer->option ? \Illuminate\Support\Str::limit($answer->option->option_text, 25) : '-' }}
                                </td>
                                <td>{{ $correctOption ? \Illuminate\Support\Str::limit($correctOption->option_text, 25) : '-' }}
                                </td>
                                <td>
                                    <span class="{{ $isCorrect ? 'correct' : 'wrong' }}">
                                        {{ $isCorrect ? '✓' : '✗' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @else
        <!-- For many participants, show note that details are available per-participant -->
        <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 8px; margin-top: 20px;">
            <p style="color: #64748b; font-size: 11px; margin: 0;">
                📋 Detail jawaban masing-masing peserta dapat dilihat melalui export PDF individual.
            </p>
        </div>
    @endif

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem {{ config('app.name') }}.</p>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }} | Total Peserta: {{ $sessions->count() }}</p>
    </div>
</body>

</html>