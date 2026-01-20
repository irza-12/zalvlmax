<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\CategoryController as SuperAdminCategoryController;
use App\Http\Controllers\SuperAdmin\QuizController as SuperAdminQuizController;
use App\Http\Controllers\SuperAdmin\MonitorController as SuperAdminMonitorController;
use App\Http\Controllers\SuperAdmin\LeaderboardController as SuperAdminLeaderboardController;
use App\Http\Controllers\SuperAdmin\StatisticsController as SuperAdminStatisticsController;
use App\Http\Controllers\SuperAdmin\SettingController as SuperAdminSettingController;
use App\Http\Controllers\SuperAdmin\ActivityLogController as SuperAdminActivityLogController;
use App\Http\Controllers\SuperAdmin\QuestionController as SuperAdminQuestionController;
use App\Http\Controllers\SuperAdmin\ReportController as SuperAdminReportController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::get('/', [\App\Http\Controllers\GuestQuizController::class, 'index'])->name('guest.join');
Route::post('/check-code', [\App\Http\Controllers\GuestQuizController::class, 'checkCode'])->name('guest.check-code');
Route::get('/enter-name', [\App\Http\Controllers\GuestQuizController::class, 'nameForm'])->name('guest.name');
Route::post('/join-quiz', [\App\Http\Controllers\GuestQuizController::class, 'join'])->name('guest.process-join');

Route::get('/dashboard', function () {
    $user = auth()->user();

    // Redirect based on role
    if ($user->isSuperAdmin()) {
        return redirect()->route('superadmin.dashboard');
    } elseif ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    // Regular user - redirect to user dashboard
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Super Admin Routes
Route::middleware(['auth'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', SuperAdminUserController::class);
    Route::post('/users/{user}/toggle-status', [SuperAdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/reset-password', [SuperAdminUserController::class, 'resetPassword'])->name('users.reset-password');

    // Categories
    Route::resource('categories', SuperAdminCategoryController::class)->except(['create', 'show', 'edit']);

    // Quizzes
    Route::resource('quizzes', SuperAdminQuizController::class);
    Route::post('/quizzes/{quiz}/duplicate', [SuperAdminQuizController::class, 'duplicate'])->name('quizzes.duplicate');

    // Questions
    Route::post('/quizzes/{quiz}/questions', [SuperAdminQuestionController::class, 'store'])->name('questions.store');
    Route::put('/questions/{question}', [SuperAdminQuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [SuperAdminQuestionController::class, 'destroy'])->name('questions.destroy');

    // Reports
    Route::get('/quizzes/sessions/{session}/export-pdf', [SuperAdminReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::get('/quizzes/{quiz}/export-excel', [SuperAdminReportController::class, 'exportExcel'])->name('reports.export-excel');
    Route::get('/quizzes/{quiz}/export-pdf-all', [SuperAdminReportController::class, 'exportPdfAll'])->name('reports.export-pdf-all');

    // Live Monitoring
    Route::get('/monitor', [SuperAdminMonitorController::class, 'index'])->name('monitor.index');
    Route::get('/monitor/{quiz}', [SuperAdminMonitorController::class, 'quiz'])->name('monitor.quiz');
    Route::get('/monitor/{quiz}/progress', [SuperAdminMonitorController::class, 'getProgress'])->name('monitor.progress');

    // Leaderboard
    Route::get('/leaderboard', [SuperAdminLeaderboardController::class, 'index'])->name('leaderboard.index');
    Route::post('/leaderboard/{quiz}/recalculate', [SuperAdminLeaderboardController::class, 'recalculate'])->name('leaderboard.recalculate');

    // Statistics
    Route::get('/statistics', [SuperAdminStatisticsController::class, 'index'])->name('statistics.index');

    // Settings
    Route::get('/settings', [SuperAdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SuperAdminSettingController::class, 'update'])->name('settings.update');

    // Activity Logs
    Route::get('/activity-logs', [SuperAdminActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::delete('/activity-logs/clear', [SuperAdminActivityLogController::class, 'clear'])->name('activity-logs.clear');
});

// User Routes
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

    // Leaderboard
    Route::get('/leaderboard', [\App\Http\Controllers\User\LeaderboardController::class, 'index'])->name('leaderboard');

    // Quizzes
    Route::post('/quizzes/join', [\App\Http\Controllers\User\QuizController::class, 'join'])->name('quizzes.join');
    Route::get('/quizzes', [\App\Http\Controllers\User\QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/{quiz}', [\App\Http\Controllers\User\QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quizzes/{quiz}/start', [\App\Http\Controllers\User\QuizController::class, 'start'])->name('quizzes.start');
    Route::get('/quizzes/{quiz}/question/{question}', [\App\Http\Controllers\User\QuizController::class, 'question'])->name('quizzes.question');
    Route::post('/quizzes/{quiz}/question/{question}', [\App\Http\Controllers\User\QuizController::class, 'submitAnswer'])->name('quizzes.submit-answer');
    Route::post('/quizzes/{quiz}/log-violation', [\App\Http\Controllers\User\QuizController::class, 'logViolation'])->name('quizzes.log-violation');
    Route::get('/quizzes/{quiz}/check-status', [\App\Http\Controllers\User\QuizController::class, 'checkStatus'])->name('quizzes.check-status'); // Handles kick & timeout
    Route::get('/quizzes/{quiz}/finish', [\App\Http\Controllers\User\QuizController::class, 'finish'])->name('quizzes.finish');

    // Results
    Route::get('/results', [\App\Http\Controllers\User\ResultController::class, 'index'])->name('results.index');
    Route::get('/results/{result}', [\App\Http\Controllers\User\ResultController::class, 'show'])->name('results.show');
    Route::get('/results/{result}/export-pdf', [\App\Http\Controllers\User\ResultController::class, 'exportPdf'])->name('results.export-pdf');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Quizzes
    Route::resource('quizzes', \App\Http\Controllers\Admin\QuizController::class);
    Route::post('/quizzes/{quiz}/toggle-status', [\App\Http\Controllers\Admin\QuizController::class, 'toggleStatus'])->name('quizzes.toggle-status');

    // Questions (Nested URL, but name matched to Admin\QuestionController expectations)
    Route::get('/quizzes/{quiz}/questions', [\App\Http\Controllers\Admin\QuestionController::class, 'index'])->name('questions.index');
    Route::get('/quizzes/{quiz}/questions/create', [\App\Http\Controllers\Admin\QuestionController::class, 'create'])->name('questions.create');
    Route::post('/quizzes/{quiz}/questions', [\App\Http\Controllers\Admin\QuestionController::class, 'store'])->name('questions.store');
    Route::get('/quizzes/{quiz}/questions/{question}/edit', [\App\Http\Controllers\Admin\QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/quizzes/{quiz}/questions/{question}', [\App\Http\Controllers\Admin\QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/quizzes/{quiz}/questions/{question}', [\App\Http\Controllers\Admin\QuestionController::class, 'destroy'])->name('questions.destroy');

    // Results (Viewing reports)
    Route::get('/results/export/excel', [\App\Http\Controllers\Admin\ResultController::class, 'exportExcel'])->name('results.export.excel');
    Route::get('/results/export/pdf', [\App\Http\Controllers\Admin\ResultController::class, 'exportPdf'])->name('results.export.pdf');
    Route::get('/results/compare', [\App\Http\Controllers\Admin\ResultController::class, 'compare'])->name('results.compare');
    Route::get('/results/compare/export/excel', [\App\Http\Controllers\Admin\ResultController::class, 'compareExportExcel'])->name('results.compare.export.excel');
    Route::get('/results/compare/export/pdf', [\App\Http\Controllers\Admin\ResultController::class, 'compareExportPdf'])->name('results.compare.export.pdf');
    Route::resource('results', \App\Http\Controllers\Admin\ResultController::class)->only(['index', 'show']);

    // Admin Users (Participants only)
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
});

require __DIR__ . '/auth.php';


