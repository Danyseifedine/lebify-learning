<?php

namespace App\Http\Controllers\Dashboard\Pages\User;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.user.overview.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->componentResponse(view('dashboard.pages.user.overview.modal.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'age' => 'required|integer',
        ]);

        $userData = $request->all();

        // Generate custom UUID
        $firstTwoLetters = strtoupper(substr($request->name, 0, 2));
        $age = $request->age;
        $lastTwoDigits = substr($request->phone, -2);
        $customUuid = $firstTwoLetters . '-' . $age . '-' . $lastTwoDigits;

        $userData['uuid'] = $customUuid;

        $user = User::create($userData);
        $user->addRole('student');

        return $this->modalToastResponse('User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return $this->componentResponse(view('dashboard.pages.user.overview.modal.show', compact('user')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return $this->componentResponse(view('dashboard.pages.user.overview.modal.edit', compact('user')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'phone' => 'required|string',
            'uuid' => 'required|string',
        ]);

        $userData = $request->all();
        if ($request->password) {
            $userData['password'] = Hash::make($request->password);
        }

        User::find($request->id)->update($userData);
        return $this->modalToastResponse('User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $users = User::select(
            'id',
            'name',
            'email',
            'phone',
            'uuid',
            'email_verified_at',
            'status',
            'created_at'
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                        ->orWhere('email', 'like', '%' . $value . '%')
                        ->orWhere('uuid', 'like', '%' . $value . '%');
                });
            });

        if ($request->status) {
            $users->where('status', $request->status);
        }

        if ($request->verified) {
            $users->where('email_verified_at', '!=', null);
        }

        if ($request->not_verified) {
            $users->where('email_verified_at', null);
        }

        return datatables::of($users->latest())
            ->editColumn('created_at', function ($user) {
                return $user->created_at->diffForHumans();
            })
            ->make(true);
    }

    public function status(string $id)
    {
        $user = User::find($id);
        if ($user->status == 'active') {
            $user->update(['status' => 'inactive']);
        } else {
            $user->update(['status' => 'active']);
        }
        return response()->json(['message' => 'User status updated successfully']);
    }

    public function verify(string $id)
    {
        $user = User::find($id);
        $user->update(['email_verified_at' => now()]);
        return response()->json(['message' => 'User verified successfully']);
    }

    public function unverify(string $id)
    {
        $user = User::find($id);
        $user->update(['email_verified_at' => null]);
        return response()->json(['message' => 'User unverified successfully']);
    }
}
