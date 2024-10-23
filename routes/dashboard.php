<?php

use App\Http\Controllers\Dashboard\DashboardController;
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

    Route::controller(UsersController::class)->group(function () {
        Route::get('users/datatable', 'datatable')->name('users.datatable');
        Route::get('users/get/{id}', 'getUser')->name('users.get');
        Route::post('users/edit', 'update')->name('users.edit');
        Route::put('users/status/{id}', 'changeStatus')->name('users.status');
        Route::resource('users', UsersController::class);
    });

    Route::controller(UserRolesController::class)->group(function () {
        Route::prefix('user/role')->name('user.role.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('datatable', 'datatable')->name('datatable');
            Route::get('get/{id}', 'getUserRole')->name('get');
            Route::post('delete', 'deleteRole')->name('delete');
            Route::post('add', 'addRole')->name('add');
        });
    });
});
