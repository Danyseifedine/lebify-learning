<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\BaseController;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuizAttemptController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.quiz.attempt.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->componentResponse(view('dashboard.pages.quiz.attempt.modal.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
        ]);

        QuizAttempt::create($request->all());
        return $this->modalToastResponse('QuizAttempt created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quizAttempt = QuizAttempt::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.attempt.modal.show', compact('quizAttempt')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quizAttempt = QuizAttempt::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.attempt.modal.edit', compact('quizAttempt')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
        ]);

        $quizAttempt = QuizAttempt::find($request->id);
        $quizAttempt->update($request->all());
        return $this->modalToastResponse('QuizAttempt updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quizAttempt = QuizAttempt::find($id);
        $quizAttempt->delete();
        return response()->json(['message' => 'QuizAttempt deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $quizAttempts = QuizAttempt::with(
            'quiz',
            'user',
        )->select(
            'id',
            'quiz_id',
            'user_id',
            'score',
            'passed',
            'status',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('quiz_id', 'like', '%' . $value . '%')
                        ->orWhere('user_id', 'like', '%' . $value . '%')
                        ->orWhere('started_at', 'like', '%' . $value . '%')
                        ->orWhere('completed_at', 'like', '%' . $value . '%')
                        ->orWhere('score', 'like', '%' . $value . '%')
                        ->orWhere('passed', 'like', '%' . $value . '%')
                        ->orWhere('reason', 'like', '%' . $value . '%')
                        ->orWhere('status', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($quizAttempts->latest())
            ->editColumn('quiz_id', function ($quizAttempt) {
                return $quizAttempt->quiz->title;
            })
            ->editColumn('user_id', function ($quizAttempt) {
                return $quizAttempt->user->name;
            })
            ->editColumn('created_at', function ($quizAttempt) {
                return $quizAttempt->created_at->diffForHumans();
            })
            ->make(true);
    }
}
