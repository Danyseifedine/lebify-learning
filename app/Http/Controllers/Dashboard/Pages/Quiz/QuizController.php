<?php

namespace App\Http\Controllers\Dashboard\Pages\Quiz;

use App\Http\Controllers\BaseController;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Duration;
use App\Models\DifficultyLevel;

class QuizController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $durations = Duration::all();
        $difficulties = DifficultyLevel::all();
        return view('dashboard.pages.quiz.overview.index', compact('user', 'durations', 'difficulties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $durations = Duration::all();
        $difficulties = DifficultyLevel::all();
        return $this->componentResponse(view('dashboard.pages.quiz.overview.modal.create', compact('durations', 'difficulties')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'duration_id' => 'required|exists:durations,id',
            'difficulty_level_id' => 'required|exists:difficulty_levels,id',
            'description' => 'required|string',
            'passing_score' => 'required|integer|min:0|max:100',
            'attempts_allowed' => 'required|integer|min:1',
        ]);

        Quiz::create($request->all());
        return $this->modalToastResponse('Quiz created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quiz = Quiz::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.overview.modal.show', compact('quiz')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $durations = Duration::all();
        $difficulties = DifficultyLevel::all();
        $quiz = Quiz::find($id);
        return $this->componentResponse(view('dashboard.pages.quiz.overview.modal.edit', compact('quiz', 'durations', 'difficulties')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'duration_id' => 'required|exists:durations,id',
            'difficulty_level_id' => 'required|exists:difficulty_levels,id',
            'passing_score' => 'required|integer|min:0|max:100',
            'attempts_allowed' => 'required|integer|min:1',
        ]);

        $quiz = Quiz::find($request->id);
        $quiz->update($request->all());
        return $this->modalToastResponse('Quiz updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quiz = Quiz::find($id);
        $quiz->delete();
        return response()->json(['message' => 'Quiz deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $quiz = Quiz::with('duration', 'difficultyLevel')->select(
            'id',
            'title',
            'duration_id',
            'difficulty_level_id',
            'passing_score',
            'is_published',
            'attempts_allowed',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('title', 'like', '%' . $value . '%')
                        ->orWhere('duration_id', 'like', '%' . $value . '%')
                        ->orWhere('difficulty_level_id', 'like', '%' . $value . '%')
                        ->orWhere('passing_score', 'like', '%' . $value . '%')
                        ->orWhere('is_published', 'like', '%' . $value . '%')
                        ->orWhere('attempts_allowed', 'like', '%' . $value . '%');
                });
            });

        if ($request->has('filter_duration_id') && !$request->filter_duration_id == null) {
            $quiz->where('duration_id', $request->filter_duration_id);
        }

        if ($request->has('filter_difficulty_level_id') && !$request->filter_difficulty_level_id == null) {
            $quiz->where('difficulty_level_id', $request->filter_difficulty_level_id);
        }

        if ($request->has('filter_is_published') && !$request->filter_is_published == null) {
            $quiz->where('is_published', true);
        }

        if ($request->has('filter_is_not_published') && !$request->filter_is_not_published == null) {
            $quiz->where('is_published', false);
        }

        return DataTables::of($quiz->latest())
            ->editColumn('created_at', function ($quiz) {
                return $quiz->created_at->diffForHumans();
            })
            ->editColumn('duration_id', function ($quiz) {
                return $quiz->duration->formatDuration();
            })
            ->editColumn('difficulty_level_id', function ($quiz) {
                return $quiz->difficultyLevel->getDifficultyName();
            })
            ->make(true);
    }

    public function status(string $id)
    {
        $quiz = Quiz::find($id);
        $quiz->is_published = !$quiz->is_published;
        $quiz->save();
        return response()->json(['message' => 'Quiz status updated successfully']);
    }
}
