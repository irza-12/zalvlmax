<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Result;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

$result = Result::find(16);
if (!$result) {
    echo "Result not found\n";
    exit;
}

$result->load(['user', 'quiz.questions.options']);

echo "Rendering Blade View...\n";
try {
    $html = View::make('admin.results.individual_pdf', compact('result'))->render();
    file_put_contents('output_test.html', $html);
    echo "Blade View OK. Saved to output_test.html\n";
} catch (\Exception $e) {
    echo "Blade View Error: " . $e->getMessage() . "\n";
    exit;
}

echo "Generating PDF...\n";
try {
    $pdf = Pdf::loadHTML($html);
    $pdf->setPaper('a4', 'portrait');
    $output = $pdf->output();
    file_put_contents('output_test.pdf', $output);
    echo "PDF Generation OK. Saved to output_test.pdf (" . strlen($output) . " bytes)\n";
} catch (\Exception $e) {
    echo "PDF Error: " . $e->getMessage() . "\n";
}
