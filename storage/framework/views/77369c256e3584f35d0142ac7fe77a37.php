<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Game - <?php echo e(config('app.name')); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f9fafb;
            /* Gray 50 - Very clean off-white */
            color: #1f2937;
            /* Gray 800 */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .join-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            /* Gray 200 */
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            /* Soft shadow */
            text-align: center;
        }

        .form-control-lg {
            border-radius: 8px;
            padding: 15px;
            font-size: 1.1rem;
            border: 1px solid #d1d5db;
            /* Gray 300 */
            text-align: center;
            letter-spacing: 1px;
            font-weight: normal;
            background-color: #ffffff;
            color: #111827;
        }

        .form-control-lg:focus {
            border-color: #4b5563;
            /* Gray 600 */
            box-shadow: 0 0 0 0.25rem rgba(75, 85, 99, 0.2);
            background-color: #fff;
        }

        .form-control-lg::placeholder {
            color: #9ca3af;
            /* Gray 400 */
        }

        .btn-join {
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
            transition: all 0.2s ease;
            letter-spacing: 0.5px;
        }

        .btn-join:hover {
            background-color: #111827;
            /* Gray 900/Black */
            transform: translateY(-1px);
        }

        .admin-link {
            position: absolute;
            top: 25px;
            right: 25px;
            color: #6b7280;
            /* Gray 500 */
            text-decoration: none;
            padding: 8px 16px;
            font-size: 0.85rem;
            transition: all 0.2s;
            font-weight: 500;
        }

        .admin-link:hover {
            color: #111827;
            /* Gray 900 */
        }
    </style>
</head>

<body>

    <a href="<?php echo e(route('login')); ?>" class="admin-link">Login Admin</a>

    <div class="join-card">
        <h2 class="mb-4 fw-bold text-dark">Gabung Kuis</h2>

        <?php if(session('error')): ?>
            <div class="alert alert-danger mb-4 rounded-3 text-start">
                <i class="bi bi-exclamation-circle me-2"></i> <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('guest.check-code')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <input type="text" name="access_code" class="form-control form-control-lg"
                    placeholder="Masukkan kode join" required autocomplete="off" autofocus>
            </div>
            <button type="submit" class="btn btn-primary btn-join">
                Masuk
            </button>
        </form>
    </div>

</body>

</html><?php /**PATH C:\Users\Hype AMD\.gemini\antigravity\scratch\coc-quiz-app\resources\views/guest/join.blade.php ENDPATH**/ ?>