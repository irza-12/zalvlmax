<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\ResultController as AdminResultController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\QuizController as UserQuizController;
use App\Http\Controllers\User\ResultController as UserResultController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return view('welcome');
})->name('home');

// Profile routes (accessible by all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Quiz management
    Route::resource('quizzes', AdminQuizController::class);
    Route::post('quizzes/{quiz}/toggle-status', [AdminQuizController::class, 'toggleStatus'])->name('quizzes.toggle-status');

    // Question management
    Route::prefix('quizzes/{quiz}')->name('questions.')->group(function () {
        Route::get('/questions', [AdminQuestionController::class, 'index'])->name('index');
        Route::get('/questions/create', [AdminQuestionController::class, 'create'])->name('create');
        Route::post('/questions', [AdminQuestionController::class, 'store'])->name('store');
        Route::get('/questions/{question}/edit', [AdminQuestionController::class, 'edit'])->name('edit');
        Route::put('/questions/{question}', [AdminQuestionController::class, 'update'])->name('update');
        Route::delete('/questions/{question}', [AdminQuestionController::class, 'destroy'])->name('destroy');
    });

    // Result management
    Route::prefix('results')->name('results.')->group(function () {
        Route::get('/', [AdminResultController::class, 'index'])->name('index');
        Route::get('/compare', [AdminResultController::class, 'compare'])->name('compare');
        Route::get('/compare/excel', [AdminResultController::class, 'compareExportExcel'])->name('compare.export.excel');
        Route::get('/compare/pdf', [AdminResultController::class, 'compareExportPdf'])->name('compare.export.pdf');
        Route::get('/{result}', [AdminResultController::class, 'show'])->name('show');
        Route::get('/leaderboard', [AdminResultController::class, 'leaderboard'])->name('leaderboard');
        Route::get('/export/excel', [AdminResultController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [AdminResultController::class, 'exportPdf'])->name('export.pdf');
    });

    // User management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::post('/{user}/change-role', [AdminUserController::class, 'changeRole'])->name('change-role');
        Route::post('/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('reset-password');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    });
});

// User routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Quiz taking
    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::get('/', [UserQuizController::class, 'index'])->name('index');
        Route::get('/{quiz}', [UserQuizController::class, 'show'])->name('show');
        Route::post('/{quiz}/start', [UserQuizController::class, 'start'])->name('start');
        Route::get('/{quiz}/question/{question}', [UserQuizController::class, 'question'])->name('question');
        Route::post('/{quiz}/question/{question}/submit', [UserQuizController::class, 'submitAnswer'])->name('submit-answer');
        Route::get('/{quiz}/finish', [UserQuizController::class, 'finish'])->name('finish');
    });

    // Results
    Route::prefix('results')->name('results.')->group(function () {
        Route::get('/', [UserResultController::class, 'index'])->name('index');
        Route::get('/{result}', [UserResultController::class, 'show'])->name('show');
    });

    // Leaderboard
    Route::get('/leaderboard/{quiz?}', [UserResultController::class, 'leaderboard'])->name('leaderboard');
});

require __DIR__ . '/auth.php';
