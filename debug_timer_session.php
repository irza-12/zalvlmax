<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\QuizSession;

$user = User::where('name', 'Timer Test User')->first();
if (!$user) {
    echo "User not found\n";
    exit;
}

echo "User ID: " . $user->id . "\n";

$session = QuizSession::where('user_id', $user->id)->latest('started_at')->first();
if ($session) {
    echo "Session ID: " . $session->id . "\n";
    echo "Status: " . $session->status . "\n";
    echo "Started At: " . $session->started_at . "\n";
    echo "Now: " . now() . "\n";

    // Test Query Timer Logic
    $sessionTimer = QuizSession::where('user_id', $user->id)
        ->where('quiz_id', $session->quiz_id)
        ->where('status', 'in_progress')
        ->first();

    echo "Timer Query Found: " . ($sessionTimer ? 'YES' : 'NO') . "\n";
} else {
    echo "No session found.\n";
}
