<?php

namespace App\Console\Commands\RolePermission\Update;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ControllerCommand extends Command
{
    protected $signature = 'update:controller-role-permission';
    protected $description = 'Update controller for role and permission';

    public function handle()
    {
        $this->updatePermissionController();
        $this->info('Controller files have been updated successfully.');
        $this->updateRoleController();
        $this->info('Controller files have been updated successfully.');
    }

    private function updatePermissionController()
    {
        $controllerPath = app_path('Http/Controllers/Dashboard/Privileges/PermissionController.php');

        if (!File::exists($controllerPath)) {
            $this->error('PermissionController.php file does not exist.');
            return;
        }

        $controllerContent = $this->getPermissionControllerContent();
        File::put($controllerPath, $controllerContent);

        $this->info('PermissionController.php file has been updated.');
    }

    private function updateRoleController()
    {
        $controllerPath = app_path('Http/Controllers/Dashboard/Privileges/RoleController.php');

        if (!File::exists($controllerPath)) {
            $this->error('RoleController.php file does not exist.');
            return;
        }

        $controllerContent = $this->getRoleControllerContent();
        File::put($controllerPath, $controllerContent);
        $this->info('RoleController.php file has been updated.');
    }


    private function getPermissionControllerContent()
    {
        return <<<'EOD'
<?php

namespace App\Http\Controllers\Dashboard\Privileges;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.privileges.permission', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'display_name' => 'required|string',
        ]);

        Permission::create($request->all());
        return response()->json(['message' => 'Permission created successfully']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'display_name' => 'required|string',
        ]);

        $permission = Permission::find($request->id);
        $permission->update($request->all());
        return response()->json(['message' => 'Permission updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return response()->json(['message' => 'Permission deleted successfully']);
    }

    /**
     * Get the datatable data for permissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $permissions = Permission::select(
            'id',
            'name',
            'display_name',
            'description',
            'created_at'
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                        ->orWhere('display_name', 'like', '%' . $value . '%')
                        ->orWhere('description', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($permissions->get())
            ->editColumn('created_at', function ($permission) {
                return $permission->created_at->diffForHumans();
            })->make(true);
    }

    /**
     * Get a specific permission by ID.
     *
     * @param string $id The ID of the permission to retrieve
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermission(string $id)
    {
        $permission = Permission::find($id);
        return response()->json($permission);
    }

    /**
     * Show roles associated with a specific permission.
     *
     * @param string $id The ID of the permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function showRole(string $id)
    {
        $permission = Permission::findOrFail($id);
        $allRoles = Role::all();
        $permissionRoles = $permission->roles()->pluck('id')->toArray();

        return response()->json([
            'permission' => $permission,
            'allRoles' => $allRoles,
            'permissionRoles' => $permissionRoles
        ]);
    }

    /**
     * Add a role to a specific permission.
     *
     * @param Request $request The request containing the role ID
     * @param string $id The ID of the permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function addRole(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->roles()->attach($request->role_id);
        return response()->json(['message' => 'Role added successfully']);
    }

    /**
     * Remove a role from a specific permission.
     *
     * @param string $id The ID of the permission
     * @param string $roleId The ID of the role to remove
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeRole(string $id, string $roleId)
    {
        $permission = Permission::findOrFail($id);
        $permission->roles()->detach($roleId);
        return response()->json(['message' => 'Role removed successfully']);
    }
}
EOD;
    }

    private function getRoleControllerContent()
    {
        return <<<'EOD'
<?php

namespace App\Http\Controllers\Dashboard\Privileges;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{


    /**
     * Display a listing of the roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.privileges.role', compact('user'));
    }

    /**
     * Store a newly created role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'display_name' => 'required|string',
        ]);

        Role::create($request->all());
        return response()->json(['message' => 'Role created successfully']);
    }

    /**
     * Remove the specified role from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully']);
    }

    /**
     * Update the specified role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'display_name' => 'required|string',
        ]);

        $role = Role::find($request->id);
        $role->update($request->all());
        return response()->json(['message' => 'Role updated successfully']);
    }

    /**
     * Get the datatable data for roles.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $roles = Role::select(
            'id',
            'name',
            'display_name',
            'description',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                        ->orWhere('display_name', 'like', '%' . $value . '%')
                        ->orWhere('description', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($roles->get())
            ->editColumn('created_at', function ($role) {
                return $role->created_at->diffForHumans();
            })->make(true);
    }

    /**
     * Get a specific role by ID.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRole(string $id)
    {
        $role = Role::find($id);
        return response()->json($role);
    }

    /**
     * Show permissions associated with a specific role.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showPermission(string $id)
    {
        $role = Role::findOrFail($id);
        $allPermissions = Permission::all();
        $rolePermissions = $role->permissions()->pluck('id')->toArray();

        return response()->json([
            'role' => $role,
            'allPermissions' => $allPermissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Add a permission to a specific role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPermission(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        $role->permissions()->attach($request->permission_id);
        return response()->json(['message' => 'Permission added successfully']);
    }

    /**
     * Remove a permission from a specific role.
     *
     * @param  string  $id
     * @param  string  $permissionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removePermission(string $id, string $permissionId)
    {
        $role = Role::findOrFail($id);
        $role->permissions()->detach($permissionId);
        return response()->json(['message' => 'Permission removed successfully']);
    }
}
EOD;
    }
}
