<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\Courses\CoursesController;
use App\Http\Controllers\Web\LandingController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Auth routes
Auth::routes(['verify' => true]);

// Student routes
Route::prefix('student')->name('students.')->group(function () {
    include __DIR__ . DIRECTORY_SEPARATOR . 'students.php';
});

// Logout route
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Dashboard routes
Route::middleware(['verified', 'role:admin|mini-admin'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    include __DIR__ . DIRECTORY_SEPARATOR . 'dashboard.php';

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        include __DIR__ . DIRECTORY_SEPARATOR . 'Privileges.php';
    });
});


Route::prefix('quizzes')->name('quizzes.')->middleware(['checkPendingQuizAttempts'])->group(function () {
    include __DIR__ . DIRECTORY_SEPARATOR . 'quizzes.php';
});

// Courses routes
Route::prefix('courses')->name('courses.')->group(function () {
    include __DIR__ . DIRECTORY_SEPARATOR . 'courses.php';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
