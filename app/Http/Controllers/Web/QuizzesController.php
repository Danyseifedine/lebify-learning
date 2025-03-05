<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Models\DifficultyLevel;
use App\Models\Duration;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizzesController extends BaseController
{
    /**
     * Display the quizzes listing page
     */
    public function index()
    {
        return view('web.quizzes.index', [
            'user' => auth()->user(),
            'role' => auth()->user()->roles->first()->name,
            'durations' => Duration::all(),
            'difficulties' => DifficultyLevel::all(),
        ]);
    }

    /**
     * Filter quizzes (AJAX request)
     */
    public function filter(Request $request)
    {
        // Eager load relationships and get quizzes with pagination
        $quizzes = Quiz::with(['difficultyLevel', 'duration'])
            ->filter($request->all())
            ->paginate(9);

        // Get quiz IDs for batch processing
        $quizIds = $quizzes->pluck('id')->toArray();

        $questionCounts = Quiz::getQuestionCountsForQuizzes($quizIds);
        $performanceStats = Quiz::getPerformanceStatsForQuizzes($quizIds);


        // Map the stats to each quiz
        $stats = $quizzes->map(function ($quiz) use ($performanceStats) {
            return $performanceStats[$quiz->id] ?? (object)[
                'total_attempts' => 0,
                'excellent' => 0,
                'good' => 0,
                'average' => 0,
                'below_average' => 0
            ];
        });

        return $this->componentResponse(
            view('web.quizzes.partials.quiz-list', compact('quizzes', 'stats', 'questionCounts'))
        );
    }

    /**
     * Show quiz page (direct access)
     */
    public function show(Quiz $quiz)
    {
        $user = auth()->user();
        $userId = $user->id;

        $attemptsEnded = $quiz->isAttemptEnded($userId);
        $questionsCount = $quiz->questionsCount();
        $userAttemptsCount = $quiz->attempts()->where('user_id', $userId)->count();
        $multipleChoiceCount = $quiz->multipleChoiceQuestionsCount();
        $totalAttemptsCount = $quiz->attempts()->count();
        $totalPassedAttemptsCount = $quiz->attempts()->where('passed', true)->count();
        $totalFailedAttemptsCount = $quiz->attempts()->where('passed', false)->count();
        $totalAbortedAttemptsCount = $quiz->attempts()->where('status', 'aborted')->count();
        $trueFalseCount = $quiz->trueFalseQuestionsCount();

        return view('web.quizzes.show', [
            'quiz' => $quiz,
            'user' => $user,
            'role' => $user->roles->first()->name,
            'attemptsEnded' => $attemptsEnded,
            'questionsCount' => $questionsCount,
            'userAttemptsCount' => $userAttemptsCount,
            'multipleChoiceCount' => $multipleChoiceCount,
            'trueFalseCount' => $trueFalseCount,
            'totalAttemptsCount' => $totalAttemptsCount,
            'totalPassedAttemptsCount' => $totalPassedAttemptsCount,
            'totalFailedAttemptsCount' => $totalFailedAttemptsCount,
            'totalAbortedAttemptsCount' => $totalAbortedAttemptsCount,
        ]);
    }

    public function details(Quiz $quiz)
    {
        $user = auth()->user();
        $userId = $user->id;

        $attemptsEnded = $quiz->isAttemptEnded($userId);
        $questionsCount = $quiz->questionsCount();
        $userAttemptsCount = $quiz->attempts()->where('user_id', $userId)->count();
        $multipleChoiceCount = $quiz->multipleChoiceQuestionsCount();
        $trueFalseCount = $quiz->trueFalseQuestionsCount();
        $totalAttemptsCount = $quiz->attempts()->count();
        $totalPassedAttemptsCount = $quiz->attempts()->where('passed', true)->count();
        $totalFailedAttemptsCount = $quiz->attempts()->where('passed', false)->count();
        $totalAbortedAttemptsCount = $quiz->attempts()->where('status', 'aborted')->count();

        $view = view('web.quizzes.partials.quiz-details', [
            'quiz' => $quiz,
            'user' => $user,
            'role' => $user->roles->first()->name,
            'attemptsEnded' => $attemptsEnded,
            'questionsCount' => $questionsCount,
            'userAttemptsCount' => $userAttemptsCount,
            'multipleChoiceCount' => $multipleChoiceCount,
            'trueFalseCount' => $trueFalseCount,
            'totalAttemptsCount' => $totalAttemptsCount,
            'totalPassedAttemptsCount' => $totalPassedAttemptsCount,
            'totalFailedAttemptsCount' => $totalFailedAttemptsCount,
            'totalAbortedAttemptsCount' => $totalAbortedAttemptsCount,
        ]);

        return $this->componentResponse($view, ['success' => true]);
    }

    public function getStartComponent(Quiz $quiz)
    {
        $attempt = $quiz->start();

        if (!$attempt->belongsToUser()) {
            abort(403);
        }

        if ($attempt->isCompletedOrInvalid()) {
            return redirect()->route('quizzes.show', $quiz);
        }

        if ($quiz->isAttemptEnded(auth()->id())) {
            return redirect()->route('quizzes.show', $quiz);
        }

        $questions = $quiz->questions()->with('answers')->get();

        $view = view('web.quizzes.partials.started-quiz', [
            'quiz' => $quiz,
            'user' => auth()->user(),
            'role' => auth()->user()->roles->first()->name,
            'attempt' => $attempt,
            'questions' => $questions
        ]);

        return $this->componentResponse($view, [
            'success' => true,
            'attempt' => $attempt,
            'quiz' => $quiz->duration->minutes,
            'redirectUrl' => route('quizzes.started', [
                'quiz' => $quiz,
                'attempt' => $attempt
            ])
        ]);
    }

    public function started(Quiz $quiz, QuizAttempt $attempt)
    {

        if ($attempt->isCompletedOrInvalid()) {
            return redirect()->route('quizzes.show', $quiz);
        }

        if (!$attempt->belongsToUser()) {
            abort(403);
        }

        if ($quiz->isAttemptEnded(auth()->id())) {
            return redirect()->route('quizzes.show', $quiz);
        }

        $questions = $quiz->questions()->get();



        return view('web.quizzes.start', [
            'quiz' => $quiz,
            'attempt' => $attempt,
            'user' => auth()->user(),
            'role' => auth()->user()->roles->first()->name,
            'questions' => $questions
        ]);
    }

    public function abortAttempt(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        if (!$attempt->belongsToUser()) {
            abort(403);
        }

        if ($attempt->status === 'pending') {
            $attempt->update([
                'status' => 'aborted',
                'passed' => false,
                'score' => 0,
                'completed_at' => now(),
                'reason' => $request->input('reason', 'unknown'),
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('quizzes.show', $quiz);
    }

    public function submitAttempt(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        DB::beginTransaction();

        try {

            foreach ($request->input('responses') as $response) {
                $attempt->responses()->create([
                    'question_id' => $response['question_id'],
                    'answer_id' => $response['answer_id'],
                ]);
            }

            $attempt->update([
                'status' => $request->input('status') == 'timeout' ? 'timeout' : 'completed',
                'completed_at' => now(),
                'passed' => $attempt->isPassed(),
                'score' => $attempt->getScore(),
            ]);

            DB::commit();


            return response()->json([
                'success' => true,
                'getCorrectAnswersCount' => $attempt->getCorrectAnswersCount(),
                'getIncorrectAnswersCount' => $attempt->getIncorrectAnswersCount(),
                'isPassed' => $attempt->isPassed(),
                'getCorrectAnswersCount' => $attempt->getCorrectAnswersCount() > $attempt->getIncorrectAnswersCount(),
                'score' => $attempt->getScore()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
