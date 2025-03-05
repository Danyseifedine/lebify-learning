<?php

use App\Http\Controllers\Web\CoursesController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::middleware(['auth', 'verified', 'role:student|admin'])->controller(CoursesController::class)->group(function () {

    // filter courses
    Route::get('/filter', 'filter')->name('filter');
    // all courses routes
    Route::get('/', 'courses')->name('index');

    Route::get('/{id}', 'singleCourse')->name('singleCourse');

    Route::get('/document/{name}/{lang}/{id}/{order}', 'document')->name('document');
});
