<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

$now = Carbon::parse('2026-01-20 08:00:00');
$future = Carbon::parse('2026-01-20 08:03:00');

echo "Now: $now\n";
echo "Future: $future\n";
echo "Diff Default: " . $now->diffInSeconds($future) . "\n";
echo "Diff Absolute True: " . $now->diffInSeconds($future, true) . "\n";
echo "Diff Absolute False: " . $now->diffInSeconds($future, false) . "\n";

$past = Carbon::parse('2026-01-20 07:57:00');
echo "Diff Past Default: " . $now->diffInSeconds($past) . "\n";
