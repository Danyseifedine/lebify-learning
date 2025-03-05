<?php

namespace App\Http\Controllers\Dashboard\Pages\Quiz;

use App\Http\Controllers\BaseController;
use App\Models\Duration;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DurationController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.quiz.duration.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->componentResponse(view('dashboard.pages.quiz.duration.modal.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'minutes' => 'required|integer',
        ]);

        Duration::create($request->all());
        return $this->modalToastResponse('Duration created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $duration = Duration::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.duration.modal.show', compact('duration')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $duration = Duration::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.duration.modal.edit', compact('duration')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'minutes' => 'required|integer',
        ]);

        $duration = Duration::find($request->id);
        $duration->update($request->all());
        return $this->modalToastResponse('Duration updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $duration = Duration::find($id);
        $duration->delete();
        return response()->json(['message' => 'Duration deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $durations = Duration::select(
            'id',
            'minutes',
            'name',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('minutes', 'like', '%' . $value . '%')
                        ->orWhere('name', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($durations->latest())
            ->addColumn('actions', function ($duration) {
                return actionButtons($duration->id);
            })
            ->make(true);
    }
}
