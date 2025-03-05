<?php

namespace App\Http\Controllers\Dashboard\Pages\Quiz;

use App\Http\Controllers\BaseController;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Quiz;
use App\Models\QuestionCategory;

class QuizQuestionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::all();
        $categories = QuestionCategory::all();
        $user = auth()->user();
        return view('dashboard.pages.quiz.question.overview.index', compact('user', 'quizzes', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $quizzes = Quiz::all();
        $categories = QuestionCategory::all();
        return $this->componentResponse(view('dashboard.pages.quiz.question.overview.modal.create', compact('quizzes', 'categories')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required',
            'category_id' => 'required',
            'question' => 'required|string',
            'type' => 'required',
            'order' => 'required'
        ]);

        QuizQuestion::create($request->all());
        return $this->modalToastResponse('Quiz Question created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quizQuestion = QuizQuestion::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.question.overview.modal.show', compact('quizQuestion')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quizzes = Quiz::all();
        $categories = QuestionCategory::all();
        $quizQuestion = QuizQuestion::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.question.overview.modal.edit', compact('quizQuestion', 'quizzes', 'categories')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required',
            'category_id' => 'required',
            'question' => 'required|string',
            'type' => 'required',
            'order' => 'required'
        ]);

        $quizQuestion = QuizQuestion::find($request->id);
        $quizQuestion->update($request->all());
        return $this->modalToastResponse('Quiz Question updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quizQuestion = QuizQuestion::find($id);
        $quizQuestion->delete();
        return response()->json(['message' => 'Quiz Question deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $quizQuestions = QuizQuestion::select(
            'id',
            'quiz_id',
            'category_id',
            'type',
            'order',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('quiz_id', 'like', '%' . $value . '%')
                        ->orWhere('category_id', 'like', '%' . $value . '%')
                        ->orWhere('question', 'like', '%' . $value . '%')
                        ->orWhere('type', 'like', '%' . $value . '%')
                        ->orWhere('order', 'like', '%' . $value . '%');
                });
            });

        if ($request->filled("filter_quiz_id")) {
            $quizQuestions->where('quiz_id', $request->filter_quiz_id);
        }

        return DataTables::of($quizQuestions->latest())
            ->editColumn('quiz_id', function ($quizQuestion) {
                return $quizQuestion->quiz->title;
            })
            ->editColumn('category_id', function ($quizQuestion) {
                return $quizQuestion->category->name;
            })
            ->make(true);
    }
}
