<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $roles = Role::all();
        return view('dashboard.pages.users.userRole', compact('user', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
        ]);

        User::create($request->all());
        return response()->json(['message' => 'UserRole created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function editRole(Request $request)
    {
        return response()->json(['message' => 'Role updated successfully']);
    }

    public function getUserRole(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $userRoles = $user->roles;

        $allRoles = Role::all();

        $nonUserRoles = $allRoles->diff($userRoles);

        return response()->json([
            'user' => $user,
            'userRoles' => $userRoles,
            'nonUserRoles' => $nonUserRoles
        ]);
    }

    public function deleteRole(Request $request)
    {
        $user = User::find($request->user_id);
        $user->roles()->detach($request->role_id);
        return response()->json(['message' => 'Role deleted successfully']);
    }

    public function addRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);

        if (!$user->hasRole($role->name)) {
            $user->roles()->attach($role);
            return response()->json(['message' => 'Role added successfully']);
        }

        return response()->json(['message' => 'User already has this role'], 422);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userrole = User::find($id);
        $userrole->delete();
        return response()->json(['message' => 'UserRole deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $userroles = User::select(
            'id',
            'name',
            'created_at'
        )
            ->with('roles') // Eager load the roles relationship
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                        ->orWhereHas('roles', function ($query) use ($value) {
                            $query->where('name', 'like', '%' . $value . '%');
                        });
                });
            });

        return DataTables::of($userroles->get())
            ->addColumn('role', function ($user) {
                return $user->roles->pluck('name')->implode(', ');
            })
            ->editColumn('created_at', function ($user) {
                return $user->created_at->diffForHumans();
            })->make(true);
    }
}
