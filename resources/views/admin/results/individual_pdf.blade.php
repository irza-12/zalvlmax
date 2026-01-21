<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sertifikat Hasil Evaluasi - {{ $result->user->name }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Bingkai Halaman menggunakan Position Fixed agar stabil */
        .border-blue {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 20px solid #1e3a8a;
            /* Biru Tua */
            z-index: -2;
        }

        .border-gold {
            position: fixed;
            top: 25px;
            left: 25px;
            right: 25px;
            bottom: 25px;
            border: 3px solid #f59e0b;
            /* Emas */
            z-index: -1;
        }

        .container {
            position: absolute;
            top: 60px;
            left: 60px;
            right: 60px;
            bottom: 60px;
            text-align: center;
        }

        .header-title {
            color: #1e3a8a;
            font-size: 38px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }

        .header-sub {
            color: #64748b;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 40px;
            letter-spacing: 4px;
        }

        .label-text {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 10px;
        }

        .user-name {
            font-size: 42px;
            font-weight: bold;
            color: #0f172a;
            display: inline-block;
            border-bottom: 2px solid #cbd5e1;
            padding-bottom: 10px;
            margin-bottom: 30px;
            text-transform: uppercase;
            min-width: 400px;
        }

        .quiz-title {
            font-size: 26px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 40px;
        }

        /* Tabel Statistik untuk Layout Presisi */
        .stats-table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .stats-table td {
            width: 33%;
            text-align: center;
            padding: 10px;
            border-right: 1px solid #e2e8f0;
        }

        .stats-table td:last-child {
            border-right: none;
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: #1e3a8a;
        }

        .stat-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #64748b;
            margin-top: 5px;
        }

        .status-box {
            display: inline-block;
            padding: 12px 50px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 20px;
            text-transform: uppercase;
        }

        .pass {
            background-color: #dcfce7;
            color: #166534;
            border: 2px solid #166534;
        }

        .fail {
            background-color: #fee2e2;
            color: #991b1b;
            border: 2px solid #991b1b;
        }

        /* Footer dengan Table agar Align Kanan Kiri pas */
        .footer-table {
            width: 100%;
            margin-top: 60px;
        }

        .footer-left {
            text-align: left;
            width: 40%;
            font-size: 12px;
            color: #64748b;
            padding-left: 20px;
        }

        .footer-right {
            text-align: center;
            width: 40%;
            padding-right: 20px;
        }

        .signature-line {
            border-bottom: 2px solid #0f172a;
            width: 200px;
            margin: 0 auto 10px auto;
            height: 50px;
            /* Space for signature */
        }
    </style>
</head>

<body>
    <!-- Border -->
    <div class="border-blue"></div>
    <div class="border-gold"></div>

    <div class="container">

        <div class="header-title">Sertifikat Hasil Evaluasi</div>
        <div class="header-sub">{{ config('app.name', 'ZalvlmaX') }} Official Report</div>

        <div class="label-text">Diberikan kepada:</div>
        <div class="user-name">{{ $result->user->name }}</div>

        <div class="label-text">Telah menyelesaikan evaluasi pada materi:</div>
        <div class="quiz-title">{{ $result->quiz->title }}</div>

        <table class="stats-table">
            <tr>
                <td>
                    <div class="stat-value">{{ number_format((float) $result->percentage, 1) }}%</div>
                    <div class="stat-label">Nilai Akhir</div>
                </td>
                <td>
                    <div class="stat-value">{{ $result->correct_answers }} / {{ $result->total_questions }}</div>
                    <div class="stat-label">Jawaban Benar</div>
                </td>
                <td>
                    <div class="stat-value">{{ $result->formatted_completion_time }}</div>
                    <div class="stat-label">Durasi Pengerjaan</div>
                </td>
            </tr>
        </table>

        <div class="status-box {{ $result->is_passed ? 'pass' : 'fail' }}">
            {{ $result->is_passed ? 'LULUS' : 'TIDAK LULUS' }}
        </div>

        <table class="footer-table">
            <tr>
                <td class="footer-left">
                    Diterbitkan secara otomatis pada:<br>
                    <strong>{{ $result->created_at->isoFormat('D MMMM YYYY') }}</strong><br>
                    ID Dokumen: #{{ $result->id }}-{{ strtoupper(substr(md5($result->created_at), 0, 5)) }}
                </td>
                <td width="20%"></td>
                <td class="footer-right">
                    <div class="signature-line"></div>
                    <strong style="color: #0f172a; font-size: 14px;">Admin Evaluasi</strong><br>
                    <span style="color: #64748b; font-size: 12px;">Penanggung Jawab</span>
                </td>
            </tr>
        </table>

    </div>
</body>

</html>