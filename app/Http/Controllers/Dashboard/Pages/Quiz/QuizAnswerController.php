<?php

namespace App\Http\Controllers\Dashboard\Pages\Quiz;

use App\Http\Controllers\BaseController;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuizAnswerController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = QuizQuestion::all();
        $user = auth()->user();
        return view('dashboard.pages.quiz.question.answer.index', compact('user', 'questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $quizQuestion = QuizQuestion::all();
        return $this->componentResponse(view('dashboard.pages.quiz.question.answer.modal.create', compact('quizQuestion')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required',
            'answer' => 'required'
        ]);

        QuizAnswer::create($request->all());
        return $this->modalToastResponse('Quiz Answer created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quizAnswer = QuizAnswer::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.question.answer.modal.show', compact('quizAnswer')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quizQuestion = QuizQuestion::all();
        $quizAnswer = QuizAnswer::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.question.answer.modal.edit', compact('quizAnswer', 'quizQuestion')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'question_id' => 'required',
            'answer' => 'required'
        ]);

        $quizAnswer = QuizAnswer::find($request->id);
        $quizAnswer->update($request->all());
        return $this->modalToastResponse('Quiz Answer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quizAnswer = QuizAnswer::find($id);
        $quizAnswer->delete();
        return response()->json(['message' => 'Quiz Answer deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $quizAnswers = QuizAnswer::select(
            'id',
            'question_id',
            'answer',
            'is_correct',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('question_id', 'like', '%' . $value . '%')
                        ->orWhere('answer', 'like', '%' . $value . '%')
                        ->orWhere('is_correct', 'like', '%' . $value . '%');
                });
            });

        if ($request->filled('filter_question_id')) {
            $quizAnswers->where('question_id', $request->filter_question_id);
        }

        return DataTables::of($quizAnswers->latest())
            ->editColumn('question_id', function ($quizAnswer) {
                return $quizAnswer->question->question;
            })
            ->make(true);
    }

    public function isCorrect(string $id)
    {
        $quizAnswer = QuizAnswer::find($id);
        $quizAnswer->is_correct = !$quizAnswer->is_correct;
        $quizAnswer->save();
        return response()->json(['message' => 'Quiz Answer updated successfully']);
    }
}
