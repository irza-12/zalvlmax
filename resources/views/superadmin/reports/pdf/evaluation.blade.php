<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Evaluasi</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #6366f1;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #1e293b;
            font-size: 24px;
            margin: 0;
            text-transform: uppercase;
        }

        .header p {
            color: #64748b;
            margin: 5px 0 0;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .meta-table td {
            padding: 8px 12px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            color: #64748b;
            width: 150px;
        }

        .score-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
        }

        .score-val {
            font-size: 32px;
            font-weight: bold;
            color: #6366f1;
            display: block;
        }

        .score-label {
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 1px;
            color: #64748b;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 11px;
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

        .section-title {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: bold;
            color: #1e293b;
        }

        table.details {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        table.details th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        table.details td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .correct {
            color: #059669;
            font-weight: bold;
        }

        .wrong {
            color: #dc2626;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Evaluasi Hasil Kuis</h1>
        <p>{{ config('app.name') }} Professional Assessment</p>
    </div>

    <table class="meta-table">
        <tr>
            <td width="60%">
                <table>
                    <tr>
                        <td class="label">Nama Peserta:</td>
                        <td><strong>{{ $session->user->name }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label">Email:</td>
                        <td>{{ $session->user->email }}</td>
                    </tr>
                    <tr>
                        <td class="label">Judul Kuis:</td>
                        <td>{{ $session->quiz->title }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Pengerjaan:</td>
                        <td>{{ $session->completed_at ? $session->completed_at->format('d F Y, H:i') . ' WIB' : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Durasi:</td>
                        <td>{{ $result ? $result->formatted_completion_time : '-' }}</td>
                    </tr>
                </table>
            </td>
            <td width="40%">
                <div class="score-box">
                    <span class="score-label">Skor Akhir</span>
                    <span class="score-val">{{ $result ? number_format($result->percentage, 0) : 0 }}</span>
                    @php
                        // Use is_passed from database for consistency
                        $isPassed = $result ? $result->is_passed : false;
                    @endphp
                    <div style="margin-top: 10px;">
                        <span class="status-badge {{ $isPassed ? 'status-pass' : 'status-fail' }}">
                            {{ $isPassed ? 'LULUS' : 'TIDAK LULUS' }}
                        </span>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Detail Jawaban</div>

    <table class="details">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Pertanyaan</th>
                <th width="20%">Jawaban Anda</th>
                <th width="20%">Kunci Jawaban</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($session->answers as $index => $answer)
                @php
                    $isCorrect = $answer->is_correct;
                    // Find correct option text
                    $correctOption = $answer->question->options->where('is_correct', true)->first();
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $answer->question->question_text }}</td>
                    <td>
                        {{ $answer->option ? $answer->option->option_text : '-' }}
                    </td>
                    <td>
                        {{ $correctOption ? $correctOption->option_text : '-' }}
                    </td>
                    <td>
                        <span class="{{ $isCorrect ? 'correct' : 'wrong' }}">
                            {{ $isCorrect ? 'Benar' : 'Salah' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem {{ config('app.name') }}.</p>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>

</html>