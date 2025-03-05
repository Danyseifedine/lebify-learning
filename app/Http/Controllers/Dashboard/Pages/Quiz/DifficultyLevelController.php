<?php

namespace App\Http\Controllers\Dashboard\Pages\Quiz;

use App\Http\Controllers\BaseController;
use App\Models\DifficultyLevel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DifficultyLevelController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.quiz.difficultyLevel.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->componentResponse(view('dashboard.pages.quiz.difficultyLevel.modal.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'name' => 'required'
        ]);

        DifficultyLevel::create($request->all());
        return $this->modalToastResponse('DifficultyLevel created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $difficultyLevel = DifficultyLevel::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.difficultyLevel.modal.show', compact('difficultyLevel')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $difficultyLevel = DifficultyLevel::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.difficultyLevel.modal.edit', compact('difficultyLevel')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'name' => 'required'
        ]);

        $difficultyLevel = DifficultyLevel::find($request->id);
        $difficultyLevel->update($request->all());
        return $this->modalToastResponse('Difficulty Level updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $difficultyLevel = DifficultyLevel::find($id);
        $difficultyLevel->delete();
        return response()->json(['message' => 'Difficulty Level deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $difficultyLevels = DifficultyLevel::select(
            'id',
            'level',
            'name',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('level', 'like', '%' . $value . '%')
                        ->orWhere('name', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($difficultyLevels->latest())
            ->addColumn('actions', function ($difficultyLevel) {
                return actionButtons($difficultyLevel->id);
            })
            ->make(true);
    }
}
