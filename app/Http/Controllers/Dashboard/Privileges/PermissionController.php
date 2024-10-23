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