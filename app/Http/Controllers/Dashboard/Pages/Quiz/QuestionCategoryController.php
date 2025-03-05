<?php

namespace App\Http\Controllers\Dashboard\Pages\Quiz;

use App\Http\Controllers\BaseController;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuestionCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.quiz.question.category.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->componentResponse(view('dashboard.pages.quiz.question.category.modal.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        QuestionCategory::create($request->all());
        return $this->modalToastResponse('Question Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $questionCategory = QuestionCategory::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.question.category.modal.show', compact('questionCategory')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $questionCategory = QuestionCategory::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.question.category.modal.edit', compact('questionCategory')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $questionCategory = QuestionCategory::find($request->id);
        $questionCategory->update($request->all());
        return $this->modalToastResponse('Question Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $questionCategory = QuestionCategory::find($id);
        $questionCategory->delete();
        return response()->json(['message' => 'Question Category deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $questionCategorys = QuestionCategory::select(
            'id',
            'name',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($questionCategorys->latest())
            ->addColumn('actions', function ($questionCategory) {
                return actionButtons($questionCategory->id);
            })
            ->make(true);
    }
}
