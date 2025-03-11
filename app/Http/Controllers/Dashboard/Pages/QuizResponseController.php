<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\BaseController;
use App\Models\QuizResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuizResponseController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.quiz.question.response.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->componentResponse(view('dashboard.pages.quiz.question.response.modal.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'attempt_id' => 'required',
            'question_id' => 'required',
            'answer_id' => 'required'
        ]);

        QuizResponse::create($request->all());
        return $this->modalToastResponse('Quiz Response created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quizResponse = QuizResponse::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.question.response.modal.show', compact('quizResponse')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quizResponse = QuizResponse::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.question.response.modal.edit', compact('quizResponse')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'attempt_id' => 'required',
            'question_id' => 'required',
            'answer_id' => 'required'
        ]);

        $quizResponse = QuizResponse::find($request->id);
        $quizResponse->update($request->all());
        return $this->modalToastResponse('QuizResponse updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quizResponse = QuizResponse::find($id);
        $quizResponse->delete();
        return response()->json(['message' => 'QuizResponse deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $quizResponses = QuizResponse::select(
            'id',
            'attempt_id',
            'question_id',
            'answer_id',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('attempt_id', 'like', '%' . $value . '%')
                        ->orWhere('question_id', 'like', '%' . $value . '%')
                        ->orWhere('answer_id', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($quizResponses->latest())
            ->editColumn('created_at', function ($quizResponse) {
                return $quizResponse->created_at->diffForHumans();
            })
            ->make(true);
    }
}
