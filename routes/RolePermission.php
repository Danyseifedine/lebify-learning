<?php

use App\Http\Controllers\Dashboard\Privileges\PermissionController;
use App\Http\Controllers\Dashboard\Privileges\RoleController;
use Illuminate\Support\Facades\Route;

// Privileges routes
Route::prefix('privileges')->name('privileges.')->group(function () {

    // Role routes
    Route::controller(RoleController::class)->prefix('roles')->name('roles.')->group(function () {
        // =================================
        // 🔍 Fetch role data for datatable
        // =================================
        Route::get('/datatable', 'datatable')->name('datatable');

        // =================================
        // 🎭 Retrieve a specific role by ID
        // =================================
        Route::get('/get/{id}', 'getRole')->name('get');

        // =================================
        // ✏️ Update an existing role
        // =================================
        Route::post('/edit', 'update')->name('edit');

        // ==========================================
        // 🔐 Display permissions for a specific role
        // ==========================================
        Route::get('/hasPermission/{id}', 'showPermission')->name('hasPermission');

        // ====================================
        // ➕ Assign a new permission to a role
        // ====================================
        Route::post('/{role}/permissions', 'addPermission')->name('addPermission');

        // ==================================
        // ➖ Revoke a permission from a role
        // ==================================
        Route::delete('/{role}/permissions/{permission}', 'removePermission')->name('removePermission');

        // ==========================================
        // 🚮 Delete a specific role
        // ==========================================
        Route::delete('/{role}', 'destroy')->name('destroy');

        // ====================================================
        // 📚 Resource routes for comprehensive role management
        // ====================================================
        Route::resource('/', RoleController::class);
    });

    // Permission routes
    Route::controller(PermissionController::class)->prefix('permissions')->name('permissions.')->group(function () {
        // =======================================
        // 🔍 Fetch permission data for datatable
        // =======================================
        Route::get('/datatable', 'datatable')->name('datatable');

        // ==========================================
        // 🔑 Retrieve a specific permission by ID
        // ==========================================
        Route::get('/get/{id}', 'getPermission')->name('get');

        // ==========================================
        // ✏️ Update an existing permission
        // ==========================================
        Route::post('/edit', 'update')->name('edit');

        // ======================================================
        // 🔗 Display roles associated with a specific permission
        // ======================================================
        Route::get('/hasRole/{id}', 'showRole')->name('hasRole');

        // ==========================================
        // ➕ Assign a new role to a permission
        // ==========================================
        Route::post('/{permission}/roles', 'addRole')->name('addRole');

        // ==========================================
        // ➖ Revoke a role from a permission
        // ==========================================
        Route::delete('/{permission}/roles/{role}', 'removeRole')->name('removeRole');

        // ==========================================
        // 🚮 Delete a specific permission
        // ==========================================
        Route::delete('/{permission}', 'destroy')->name('destroy');

        // ==========================================================
        // 📚 Resource routes for comprehensive permission management
        // ==========================================================
        Route::resource('/', PermissionController::class);
    });
});
