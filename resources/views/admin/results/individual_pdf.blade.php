<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>E-Certificate - {{ $result->user->name }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #334155;
        }

        /* --- BACKGROUND ACCENTS (Modern Shapes) --- */
        /* Aksen Samping Kiri (Biru Navy) */
        .accent-left {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 80px;
            background-color: #1e3a8a;
            /* Brand Blue */
            z-index: -1;
        }

        /* Aksen Garis Emas Vertikal */
        .accent-line {
            position: fixed;
            top: 0;
            left: 80px;
            bottom: 0;
            width: 5px;
            background-color: #f59e0b;
            /* Gold */
            z-index: -1;
        }

        /* Aksen Pojok Kanan Atas (Segitiga Abstrak via Border) */
        .corner-accent {
            position: fixed;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-top: 150px solid #f1f5f9;
            /* Light Gray */
            border-left: 150px solid transparent;
            z-index: -2;
        }

        .container {
            position: absolute;
            top: 0;
            left: 85px;
            right: 0;
            bottom: 0;
            /* Padding dari kiri karena ada aksen */
            padding: 50px 60px;
        }

        /* --- HEADER --- */
        .header-table {
            width: 100%;
            margin-bottom: 60px;
        }

        .app-name {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .cert-label {
            font-size: 14px;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 5px;
            letter-spacing: 4px;
        }

        .cert-id {
            text-align: right;
            font-size: 10px;
            color: #94a3b8;
            font-family: monospace;
        }

        /* --- CONTENT --- */
        .content-area {
            margin-top: 40px;
        }

        .presented-text {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #64748b;
            margin-bottom: 20px;
        }

        .recipient-name {
            font-size: 48px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 10px;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .divider {
            width: 100px;
            height: 4px;
            background-color: #f59e0b;
            /* Gold Divider */
            margin-bottom: 30px;
        }

        .description {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 40px;
            color: #475569;
            width: 90%;
        }

        .highlight {
            color: #1e3a8a;
            font-weight: bold;
        }

        /* --- STATS CARD (Modern Box) --- */
        .stats-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #1e3a8a;
            padding: 20px;
            border-radius: 8px;
            /* DOMPDF supports simple radius */
            width: 100%;
            margin-bottom: 50px;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
        }

        .stats-table td {
            vertical-align: middle;
            padding: 5px 20px;
            border-right: 1px solid #cbd5e1;
        }

        .stats-table td:last-child {
            border-right: none;
        }

        .stat-val {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
        }

        .stat-lbl {
            font-size: 10px;
            text-transform: uppercase;
            color: #64748b;
            margin-top: 4px;
        }

        /* --- FOOTER --- */
        .footer-table {
            width: 100%;
            margin-top: 60px;
        }

        .date {
            font-size: 14px;
            color: #334155;
        }

        .auth-sign {
            text-align: right;
            padding-right: 20px;
        }

        .sign-img {
            height: 50px;
            margin-bottom: 10px;
            /* Placeholder space if no image */
        }

        .sign-name {
            font-weight: bold;
            color: #0f172a;
            font-size: 16px;
            border-top: 2px solid #0f172a;
            display: inline-block;
            padding-top: 10px;
            min-width: 200px;
            text-align: center;
        }

        .sign-title {
            display: block;
            font-size: 12px;
            color: #64748b;
            text-align: center;
            margin-top: 2px;
        }

        /* Status Badge Modern */
        .badge {
            background: #1e3a8a;
            color: #fff;
            padding: 5px 15px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }

        .badge-fail {
            background: #991b1b;
        }
    </style>
</head>

<body>
    <!-- Modern Geometric Accents -->
    <div class="accent-left"></div>
    <div class="accent-line"></div>
    <div class="corner-accent"></div>

    <div class="container">

        <!-- Header: Brand & ID -->
        <table class="header-table">
            <tr>
                <td>
                    <div class="app-name">
                        {{ config('app.name', 'ZalvlmaX') }}
                        @if($result->is_passed)
                            <span class="badge">Verified Pass</span>
                        @else
                            <span class="badge badge-fail">Completed</span>
                        @endif
                    </div>
                    <div class="cert-label">Certificate of Completion</div>
                </td>
                <td class="cert-id" valign="top">
                    NO: {{ str_pad($result->id, 6, '0', STR_PAD_LEFT) }}/{{ $result->created_at->format('Y') }}<br>
                    UID: {{ strtoupper(substr(md5($result->user_id), 0, 8)) }}
                </td>
            </tr>
        </table>

        <!-- Main Content -->
        <div class="content-area">
            <div class="presented-text">This certificate is proudly presented to</div>

            <div class="recipient-name">{{ $result->user->name }}</div>
            <div class="divider"></div>

            <div class="description">
                For successfully completing the assessment requirements for<br>
                <span class="highlight">{{ $result->quiz->title }}</span>
                with an excellent performance.
            </div>

            <!-- Modern Stats Bar -->
            <div class="stats-box">
                <table class="stats-table">
                    <tr>
                        <td>
                            <div class="stat-val">{{ number_format((float) $result->percentage, 1) }}%</div>
                            <div class="stat-lbl">Final Score</div>
                        </td>
                        <td>
                            <div class="stat-val">{{ $result->correct_answers }}</div>
                            <div class="stat-lbl">Correct Answers</div>
                        </td>
                        <td>
                            <div class="stat-val">{{ $result->formatted_completion_time }}</div>
                            <div class="stat-lbl">Duration</div>
                        </td>
                        <td style="border: none;">
                            <div class="stat-val" style="color: {{ $result->is_passed ? '#16a34a' : '#dc2626' }}">
                                {{ $result->is_passed ? 'PASSED' : 'NON-PASSED' }}
                            </div>
                            <div class="stat-lbl">Final Status</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <table class="footer-table">
            <tr>
                <td valign="bottom">
                    <div class="date">
                        Issued on<br>
                        <strong>{{ $result->created_at->format('F d, Y') }}</strong>
                    </div>
                </td>
                <td class="auth-sign" valign="bottom">
                    <!-- Signature Line -->
                    <div class="sign-name">Admin Evaluasi</div>
                    <span class="sign-title">Authorized Signature</span>
                </td>
            </tr>
        </table>

    </div>
</body>

</html>