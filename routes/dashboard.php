<?php

use App\Http\Controllers\Dashboard\Courses\CourseDocumentsController;
use App\Http\Controllers\Dashboard\Courses\CoursesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\InstructorsController;
use App\Http\Controllers\Dashboard\User\UserRolesController;
use App\Http\Controllers\Dashboard\User\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;






Route::prefix('dashboard')->name('dashboard.')->group(function () {

    include __DIR__ . '/RolePermission.php';

    // Dashboard routes
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    // Users routes
    Route::controller(UsersController::class)->group(function () {
        Route::get('users/datatable', 'datatable')->name('users.datatable');
        Route::get('users/get/{id}', 'getUser')->name('users.get');
        Route::post('users/edit', 'update')->name('users.edit');
        Route::put('users/status/{id}', 'changeStatus')->name('users.status');
        Route::post('users/convert', 'convertToInstructor')->name('users.convert');
        Route::resource('users', UsersController::class);
    });

    // User roles routes
    Route::controller(UserRolesController::class)->group(function () {
        Route::prefix('user/role')->name('user.role.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('datatable', 'datatable')->name('datatable');
            Route::get('get/{id}', 'getUserRole')->name('get');
            Route::post('delete', 'deleteRole')->name('delete');
            Route::post('add', 'addRole')->name('add');
        });
    });

    // Instructors routes
    Route::controller(InstructorsController::class)->group(function () {
        Route::prefix('instructors')->name('instructors.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::delete('delete/{id}', 'destroy')->name('delete');
            Route::get('datatable', 'datatable')->name('datatable');
            Route::get('get/{id}', 'getInstructor')->name('get');
            Route::post('edit', 'update')->name('edit');
        });
    });

    // Courses routes
    Route::controller(CoursesController::class)->group(function () {
        Route::get('courses/datatable', 'datatable')->name('courses.datatable');
        Route::get('courses/get/{id}', 'getCourses')->name('courses.get');
        Route::post('courses/edit', 'update')->name('courses.edit');
        Route::put('courses/status/{id}', 'changeStatus')->name('courses.status');
        Route::resource('courses', CoursesController::class);
    });

    // Course documents routes
    Route::controller(CourseDocumentsController::class)->group(function () {
        Route::prefix('course/documents')->name('course.documents.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::get('datatable', 'datatable')->name('datatable');
            Route::get('get/{id}', 'getCourseDocuments')->name('get');
            Route::post('edit', 'update')->name('edit');
            Route::delete('delete/{id}', 'destroy')->name('delete');
        });
    });
});
