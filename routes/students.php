


<?php

use App\Http\Controllers\Web\StudentController;
use Illuminate\Support\Facades\Route;

Route::post('/student/login', [StudentController::class, 'login'])->name('login');
Route::post('/student/feedback', [StudentController::class, 'feedback'])->name('feedback');


Route::middleware(['auth', 'role:student|admin'])->controller(StudentController::class)->group(function () {

    // profile routes
    Route::get('/profile', 'profile')->name('profile');
    Route::get('/profile/tabs', 'profileTabs')->name('profile.tabs');
    Route::post('/profile/settings/update', 'updateSettings')->name('profile.settings.update');

    // courses routes
    Route::get('/courses', 'courses')->name('courses');
    Route::get('/courses/{id}', 'singleCourse')->name('singleCourse');
    Route::get('/courses/document/{name}/{lang}/{id}', 'document')->name('document');
});
