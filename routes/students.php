

<?php

use App\Http\Controllers\Web\StudentController;
use Illuminate\Support\Facades\Route;

// login routes
Route::post('/student/login', [StudentController::class, 'login'])->name('login');
// feedback routes
Route::post('/student/feedback', [StudentController::class, 'feedback'])->name('feedback');

Route::middleware(['auth', 'verified', 'role:student|admin'])->controller(StudentController::class)->group(function () {

    // profile routes
    Route::get('/profile', 'profile')->name('profile');
    // profile tabs routes
    Route::get('/profile/tabs', 'profileTabs')->name('profile.tabs');
    // profile settings routes
    Route::post('/profile/settings/update', 'updateSettings')->name('profile.settings.update');
    // profile quizzes routes
    Route::get('/profile/quizzes', 'getProfileQuizzes')->name('profile.quizzes');

    // all courses routes
    Route::get('/courses', 'courses')->name('courses');
    // single course routes
    Route::get('/courses/{id}', 'singleCourse')->name('singleCourse');
    // documents routes
    Route::get('/courses/document/{name}/{lang}/{id}/{order}', 'document')->name('document');

    // coin wallet routes
    Route::get('/create-wallet', 'createWallet')->name('createWallet');
});
