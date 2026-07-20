<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\FlashcardSetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudySessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');

    Route::resource('flashcard-sets', FlashcardSetController::class)
        ->parameters(['flashcard-sets' => 'flashcardSet']);

    Route::post('/flashcard-sets/{flashcardSet}/cards', [FlashcardController::class, 'store'])
        ->name('flashcards.store');
    Route::put('/flashcard-sets/{flashcardSet}/cards/{flashcard}', [FlashcardController::class, 'update'])
        ->name('flashcards.update');
    Route::delete('/flashcard-sets/{flashcardSet}/cards/{flashcard}', [FlashcardController::class, 'destroy'])
        ->name('flashcards.destroy');

    Route::post('/study-sessions/{flashcardSet}/start', [StudySessionController::class, 'start'])
        ->name('study-sessions.start');
    Route::get('/study-sessions/{studySession}', [StudySessionController::class, 'show'])
        ->name('study-sessions.show');
    Route::post('/study-sessions/{studySession}/answer', [StudySessionController::class, 'answer'])
        ->name('study-sessions.answer');

    Route::get('/quiz/{flashcardSet}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{flashcardSet}', [QuizController::class, 'submit'])->name('quiz.submit');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function (): void {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
        Route::patch('/public-sets/{flashcardSet}/toggle', [AdminController::class, 'toggleSetVisibility'])->name('sets.toggle');
    });
});
