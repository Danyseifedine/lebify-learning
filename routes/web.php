<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Web\LandingController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




// language middleware
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {

    // Landing page
    Route::get('/', [LandingController::class, 'index'])->name('landing');

    // Auth routes
    Auth::routes();

    // Student routes
    Route::prefix('student')->name('students.')->group(function () {
        include __DIR__ . DIRECTORY_SEPARATOR . 'students.php';
    });

    // Logout route
    Route::middleware(['auth'])->group(function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    });

    // Dashboard routes
    Route::middleware(['verified', 'role:admin'])->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        include __DIR__ . DIRECTORY_SEPARATOR . 'dashboard.php';
    });
});
