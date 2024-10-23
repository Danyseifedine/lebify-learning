<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.users.users', compact('user'));
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
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'phone' => 'required|string',
            'uuid' => 'required|string',
        ]);

        User::find($request->id)->update($request->all());
        return response()->json(['message' => 'Users updated successfully']);
    }

    public function changeStatus($id, Request $request)
    {
        $user = User::find($request->id);
        if ($user->status == 'active') {
            $user->status = 'inactive';
        } else {
            $user->status = 'active';
        }
        $user->save();
        return response()->json(['message' => 'Users status updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::find($id);
        $users->delete();
        return response()->json(['message' => 'Users deleted successfully']);
    }

    public function convertToInstructor(Request $request)
    {

        $request->validate([
            'specialization' => 'required|string',
        ]);

        $user = User::find($request->id);
        $instructor = Instructor::create([
            'user_id' => $user->id,
            'specialization' => $request->specialization,
        ]);
        return $this->modalToastResponse('User converted to instructor successfully');
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $userss = User::select(
            'id',
            'name',
            'uuid',
            'phone',
            'status',
            'created_at'
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                        ->orWhere('uuid', 'like', '%' . $value . '%')
                        ->orWhere('phone', 'like', '%' . $value . '%')
                        ->orWhere('status', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($userss->get())
            ->editColumn('created_at', function ($users) {
                return $users->created_at->diffForHumans();
            })->make(true);
    }

    public function getUser(string $id)
    {
        $user = User::find($id);
        $user->isInstructor = $user->isInstructor();
        return response()->json($user);
    }
}
