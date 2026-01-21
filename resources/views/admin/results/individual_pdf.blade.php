<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sertifikat Hasil Evaluasi - {{ $result->user->name }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            color: #333;
        }

        .container {
            width: 100%;
            height: 100%;
            padding: 20px;
            box-sizing: border-box;
            position: absolute;
            /* Fix for DOMPDF full height */
            top: 0;
            left: 0;
        }

        .border-outer {
            width: 100%;
            height: 100%;
            border: 5px solid #1e3a8a;
            /* Brand Blue */
            box-sizing: border-box;
            padding: 5px;
            position: relative;
        }

        .border-inner {
            width: 100%;
            height: 100%;
            border: 2px solid #fbbf24;
            /* Amber/Gold */
            box-sizing: border-box;
            padding: 40px;
            text-align: center;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgdmlld0JveD0iMCAwIDIwIDIwIiBmaWxsPSJub25lIiBzdHJva2U9IiNmM2Y0ZjYiIHN0cm9rZS13aWR0aD0iMSI+PHBhdGggZD0iTTEgMWwxOCAxOIEtMSAxIi8+PC9zdmc+') repeat;
        }

        .header-title {
            font-family: 'Georgia', serif;
            font-size: 42px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1e3a8a;
            letter-spacing: 4px;
            margin-bottom: 10px;
            margin-top: 20px;
        }

        .header-subtitle {
            font-size: 16px;
            color: #64748b;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 40px;
        }

        .content-text {
            font-size: 18px;
            color: #475569;
            margin-bottom: 10px;
        }

        .recipient-name {
            font-family: 'Georgia', serif;
            font-size: 48px;
            font-weight: bold;
            color: #0f172a;
            margin: 20px 0;
            border-bottom: 2px solid #e2e8f0;
            display: inline-block;
            padding: 0 50px 10px 50px;
            min-width: 400px;
        }

        .quiz-box {
            margin: 30px auto;
            max-width: 800px;
        }

        .quiz-title {
            font-size: 26px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 10px;
        }

        /* Stats Row */
        .stats-container {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .stats-table {
            width: 70%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        .stats-table td {
            text-align: center;
            width: 33%;
            padding: 10px;
            border-right: 1px solid #e2e8f0;
        }

        .stats-table td:last-child {
            border-right: none;
        }

        .stat-val {
            font-size: 32px;
            font-weight: bold;
            color: #1e3a8a;
        }

        .stat-lbl {
            font-size: 12px;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        .status-badge {
            display: inline-block;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 18px;
            margin-top: 10px;
        }

        .status-passed {
            background-color: #dcfce7;
            color: #166534;
            border: 2px solid #166534;
        }

        .status-failed {
            background-color: #fee2e2;
            color: #991b1b;
            border: 2px solid #991b1b;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            position: relative;
        }

        .signature-block {
            float: right;
            width: 250px;
            text-align: center;
            margin-right: 50px;
        }

        .date-block {
            float: left;
            width: 250px;
            text-align: left;
            margin-left: 50px;
            padding-top: 40px;
            color: #64748b;
            font-size: 12px;
        }

        .sig-line {
            border-bottom: 1px solid #0f172a;
            margin-bottom: 5px;
            margin-top: 60px;
        }

        .sig-name {
            font-weight: bold;
            font-size: 14px;
        }

        .sig-title {
            font-size: 12px;
            color: #64748b;
        }

        /* Decorative Corners */
        .corner {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 4px solid #1e3a8a;
        }

        .tl {
            top: 10px;
            left: 10px;
            border-right: none;
            border-bottom: none;
        }

        .tr {
            top: 10px;
            right: 10px;
            border-left: none;
            border-bottom: none;
        }

        .bl {
            bottom: 10px;
            left: 10px;
            border-right: none;
            border-top: none;
        }

        .br {
            bottom: 10px;
            right: 10px;
            border-left: none;
            border-top: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="border-outer">
            <div class="border-inner">
                <!-- Decorations -->
                <div class="corner tl"></div>
                <div class="corner tr"></div>
                <div class="corner bl"></div>
                <div class="corner br"></div>

                <div class="header-title">Sertifikat Hasil Evaluasi</div>
                <div class="header-subtitle">{{ config('app.name', 'ZalvlmaX') }} Official Report</div>

                <div class="content">
                    <div class="content-text">Diberikan sebagai bukti kelulusan evaluasi kepada:</div>
                    <div class="recipient-name">{{ mb_strtoupper($result->user->name) }}</div>

                    <div class="quiz-box">
                        <div class="content-text">Atas partisipasi dan penyelesaian pada materi:</div>
                        <div class="quiz-title">{{ $result->quiz->title }}</div>
                    </div>

                    <div class="stats-container">
                        <table class="stats-table">
                            <tr>
                                <td>
                                    <div class="stat-val">{{ number_format($result->percentage, 1) }}%</div>
                                    <div class="stat-lbl">Nilai Akhir</div>
                                </td>
                                <td>
                                    <div class="stat-val">{{ $result->correct_answers }} /
                                        {{ $result->total_questions }}</div>
                                    <div class="stat-lbl">Jawaban Benar</div>
                                </td>
                                <td>
                                    <div class="stat-val">{{ $result->formatted_completion_time }}</div>
                                    <div class="stat-lbl">Durasi</div>
                                </td>
                            </tr>
                        </table>

                        <br>
                        <div class="status-badge {{ $result->is_passed ? 'status-passed' : 'status-failed' }}">
                            {{ $result->is_passed ? 'LULUS (PASSED)' : 'TIDAK LULUS (FAILED)' }}
                        </div>
                    </div>

                    <div class="footer">
                        <div class="date-block">
                            Diterbitkan pada:<br>
                            <strong>{{ $result->created_at->isoFormat('D MMMM YYYY') }}</strong><br>
                            ID Dokumen: #{{ $result->id }}-{{ Str::random(5) }}
                        </div>
                        <div class="signature-block">
                            <div class="sig-line"></div>
                            <div class="sig-name">Admin Evaluasi</div>
                            <div class="sig-title">Penanggung Jawab</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>