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