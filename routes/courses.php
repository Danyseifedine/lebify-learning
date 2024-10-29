


<?php

use App\Http\Controllers\Web\CoursesController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified', 'role:student|admin'])->controller(CoursesController::class)->group(function () {

    // all courses routes
    Route::get('/', 'courses')->name('index');
    // single course routes
    Route::get('/{id}', 'singleCourse')->name('singleCourse');
    // documents routes
    Route::get('/document/{name}/{lang}/{id}/{order}', 'document')->name('document');
});
