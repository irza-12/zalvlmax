<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\QuizSession;

$session = QuizSession::latest()->first();
if ($session) {
    echo "ID: " . $session->id . "\n";
    echo "Started At: " . $session->started_at . "\n";
    echo "Now: " . now() . "\n";
    echo "Diff (sec): " . now()->diffInSeconds($session->started_at) . "\n";
    echo "Status: " . $session->status . "\n";
} else {
    echo "No session found.\n";
}
