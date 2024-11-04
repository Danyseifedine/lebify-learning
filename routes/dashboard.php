<?php

use App\Http\Controllers\Dashboard\Courses\CourseDocumentsController;
use App\Http\Controllers\Dashboard\Courses\CourseExtentionController;
use App\Http\Controllers\Dashboard\Courses\CourseLessonsController;
use App\Http\Controllers\Dashboard\Courses\CourseRelatedChannelController;
use App\Http\Controllers\Dashboard\Courses\CourseResourceController;
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
        Route::post('send/email', 'sendEmail')->name('send.email');
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
        Route::prefix('course')->name('course.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('datatable', 'datatable')->name('datatable');
            Route::get('get/{id}', 'getCourses')->name('get');
            Route::post('edit', 'update')->name('edit');
            Route::put('status/{id}', 'changeStatus')->name('status');
            Route::post('store', 'store')->name('store');
        });
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

    // Course related channels routes
    Route::controller(CourseRelatedChannelController::class)->group(function () {
        Route::prefix('course/related/channels')->name('course.related.channels.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::get('datatable', 'datatable')->name('datatable');
            Route::get('get/{id}', 'getCourseRelatedChannel')->name('get');
            Route::post('edit', 'update')->name('edit');
            Route::delete('delete/{id}', 'destroy')->name('delete');
        });
    });

    Route::controller(CourseLessonsController::class)->group(function () {
        Route::prefix('course/lessons')->name('course.lessons.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::put('status/{id}', 'changeStatus')->name('status');
            Route::delete('delete/{id}', 'destroy')->name('delete');
            Route::get('datatable', 'datatable')->name('datatable');
            Route::get('get/{id}', 'getCourseLesson')->name('get');
            Route::post('edit', 'update')->name('edit');
        });
    });

    Route::controller(CourseResourceController::class)->group(function () {
        Route::prefix('course/resources')->name('course.resources.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::get('datatable', 'datatable')->name('datatable');
            Route::get('get/{id}', 'getCourseResource')->name('get');
            Route::post('edit', 'update')->name('edit');
            Route::delete('delete/{id}', 'destroy')->name('delete');
            Route::put('status/{id}', 'changeStatus')->name('status');
        });
    });

    Route::controller(CourseExtentionController::class)->group(function () {
        Route::prefix('course/extentions')->name('course.extentions.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::get('datatable', 'datatable')->name('datatable');
            Route::get('get/{id}', 'getCourseExtention')->name('get');
            Route::put('status/{id}', 'changeStatus')->name('status');
            Route::post('edit', 'update')->name('edit');
            Route::delete('delete/{id}', 'destroy')->name('delete');
        });
    });
});
