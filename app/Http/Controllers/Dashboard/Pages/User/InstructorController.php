<?php

namespace App\Http\Controllers\Dashboard\Pages\User;

use App\Http\Controllers\BaseController;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InstructorController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.user.instructor.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return $this->componentResponse(view('dashboard.pages.user.instructor.modal.create', compact('users')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'specialization' => 'required',
        ]);

        Instructor::create($request->all());
        return $this->modalToastResponse('Instructor created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $instructor = Instructor::find($id);
        return $this->componentResponse(view('dashboard.pages.user.instructor.modal.show', compact('instructor')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $instructor = Instructor::find($id);
        $users = User::all();
        return $this->componentResponse(view('dashboard.pages.user.instructor.modal.edit', compact('instructor', 'users')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'specialization' => 'required',
        ]);

        $instructor = Instructor::find($request->id);
        $instructor->update($request->all());
        return $this->modalToastResponse('Instructor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instructor = Instructor::find($id);
        $instructor->delete();
        return response()->json(['message' => 'Instructor deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $instructors = Instructor::with('user')->select(
            'id',
            'user_id',
            'specialization',
            'bio',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('user_id', 'like', '%' . $value . '%')
                        ->orWhere('specialization', 'like', '%' . $value . '%')
                        ->orWhere('bio', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($instructors->latest())
            ->editColumn('created_at', function ($instructor) {
                return $instructor->created_at->diffForHumans();
            })
            ->editColumn('user_id', function ($instructor) {
                return $instructor->user->name;
            })
            ->make(true);
    }
}
