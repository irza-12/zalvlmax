<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masukkan Nama - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f9fafb;
            /* Gray 50 */
            color: #1f2937;
            /* Gray 800 */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .name-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            /* Gray 200 */
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .form-control-lg {
            background: #ffffff;
            border: 1px solid #d1d5db;
            /* Gray 300 */
            color: #111827;
            /* Gray 900 */
            border-radius: 8px;
            padding: 15px;
            font-size: 1.1rem;
            text-align: center;
        }

        .form-control-lg:focus {
            background: #ffffff;
            border-color: #4b5563;
            /* Gray 600 */
            color: #111827;
            box-shadow: 0 0 0 0.25rem rgba(75, 85, 99, 0.2);
        }

        .form-control-lg::placeholder {
            color: #9ca3af;
            /* Gray 400 */
        }

        .btn-start {
            background-color: #374151;
            /* Gray 700 */
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s;
        }

        .btn-start:hover {
            background-color: #111827;
            /* Gray 900 */
            transform: translateY(-1px);
        }

        .quiz-info {
            background: #f3f4f6;
            /* Gray 100 */
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 30px;
            color: #4b5563;
            /* Gray 600 */
        }

        .quiz-title {
            color: #111827;
            /* Gray 900 */
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="name-card">
        <div class="quiz-info">
            <small class="text-uppercase" style="color: #6b7280; font-weight: 600; letter-spacing: 0.5px;">Anda akan
                mengikuti kuis:</small>
            <h4 class="mb-0 mt-2 quiz-title">{{ $quiz->title }}</h4>
        </div>

        <h3 class="mb-4 fw-bold" style="color: #111827;">Siapa nama Anda?</h3>

        <form action="{{ route('guest.process-join') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" class="form-control form-control-lg"
                    placeholder="Ketik nama Anda di sini..." required autocomplete="off" autofocus maxlength="50">
            </div>
            <button type="submit" class="btn btn-start">
                Mulai Game!
            </button>
        </form>
    </div>

</body>

</html>