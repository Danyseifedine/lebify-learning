<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InstructorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.instructors.instructors', compact('user'));
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
            'specialization' => 'required|string',
        ]);

        Instructor::create($request->all());
        return response()->json(['message' => 'Instructors created successfully']);
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
            'specialization' => 'required|string',
        ]);

        Instructor::find($request->id)->update($request->all());
        return response()->json(['message' => 'Instructors updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instructors = Instructor::find($id);
        $instructors->delete();
        return response()->json(['message' => 'Instructors deleted successfully']);
    }

    public function getInstructor(string $id)
    {
        $Instructors = Instructor::find($id);
        return response()->json($Instructors);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $instructors = Instructor::select(
            'instructors.id',
            'users.name',
            'instructors.specialization',
            'instructors.created_at'
        )
            ->join('users', 'instructors.user_id', '=', 'users.id')
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('users.name', 'like', '%' . $value . '%')
                        ->orWhere('instructors.specialization', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($instructors->get())
            ->editColumn('created_at', function ($instructor) {
                return $instructor->created_at->diffForHumans();
            })->make(true);
    }
}
