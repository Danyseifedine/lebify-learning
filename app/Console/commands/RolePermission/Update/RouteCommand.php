<?php

namespace App\Console\Commands\RolePermission\Update;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RouteCommand extends Command
{
    protected $signature = 'update:route-role-permission';
    protected $description = 'Update route for role permission and include in dashboard';

    public function handle()
    {
        $this->updateRolePermissionRoute();
        $this->updateDashboardRoute();

        $this->info('Route files have been updated successfully.');
    }

    private function updateRolePermissionRoute()
    {
        $routePath = base_path('routes/RolePermission.php');

        if (!File::exists($routePath)) {
            $this->error('RolePermission.php route file does not exist.');
            return;
        }

        $routeContent = $this->getRolePermissionRouteContent();
        File::put($routePath, $routeContent);

        $this->info('RolePermission.php route file has been updated.');
    }

    private function updateDashboardRoute()
    {
        $dashboardRoutePath = base_path('routes/dashboard.php');

        if (!File::exists($dashboardRoutePath)) {
            $this->error('dashboard.php route file does not exist.');
            return;
        }

        $dashboardContent = File::get($dashboardRoutePath);

        if (strpos($dashboardContent, "include __DIR__ . '/RolePermission.php';") === false) {
            $updatedContent = str_replace(
                "Route::prefix('dashboard')->name('dashboard.')->group(function () {",
                "Route::prefix('dashboard')->name('dashboard.')->group(function () {\n\n    include __DIR__ . '/RolePermission.php';",
                $dashboardContent
            );

            File::put($dashboardRoutePath, $updatedContent);
            $this->info('dashboard.php route file has been updated to include RolePermission.php.');
        } else {
            $this->info('RolePermission.php is already included in dashboard.php.');
        }
    }

    private function getRolePermissionRouteContent()
    {
        return <<<EOD
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

EOD;
    }
}
