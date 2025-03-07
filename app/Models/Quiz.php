<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration_id',
        'difficulty_level_id',
        'passing_score',
        'is_published',
        'attempts_allowed',
        'translated'
    ];

    public function duration()
    {
        return $this->belongsTo(Duration::class);
    }

    public function difficultyLevel()
    {
        return $this->belongsTo(DifficultyLevel::class, 'difficulty_level_id');
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function allQuestions()
    {
        return $this->questions()->with('answers');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function questionsCount()
    {
        return $this->questions()->count();
    }

    public function attemptsCount()
    {
        return $this->attempts;
    }

    public function multipleChoiceQuestionsCount()
    {
        return $this->questions()->where('type', 'multiple_choice')->count();
    }

    public function trueFalseQuestionsCount()
    {
        return $this->questions()->where('type', 'true_false')->count();
    }

    public function isPublished()
    {
        return $this->is_published;
    }

    public function isTranslated()
    {
        return $this->translated;
    }

    public function getTitle()
    {
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title;
    }

    // In Quiz.php model

    public function isAttemptEnded($userId)
    {
        $completedAttemptsCount = $this->attempts()
            ->where('user_id', $userId)
            ->whereIn('status', ['completed', 'aborted', 'timeout'])
            ->count();

        return $completedAttemptsCount >= $this->attempts_allowed;
    }

    public function getAllQuestionsWithAnswers()
    {
        return $this->questions()->with('answers')->get();
    }

    public function getDurationName()
    {
        return app()->getLocale() == 'ar' ? $this->duration->name_ar : $this->duration->name;
    }

    public function getDifficultyLevelName()
    {
        return app()->getLocale() == 'ar' ? $this->difficultyLevel->name_ar : $this->difficultyLevel->name;
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['duration'])) {
            $query->where('duration_id', $filters['duration']);
        }
        if (isset($filters['difficulty'])) {
            $query->where('difficulty_level_id', $filters['difficulty']);
        }
        if (isset($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }
        return $query;
    }

    public function getAttempt()
    {
        return $this->attempts()->where('user_id', auth()->user()->id)->first();
    }

    public function start()
    {
        return $this->attempts()->create([
            'user_id' => auth()->user()->id,
            'started_at' => now(),
            'status' => 'pending',
        ]);
    }

    public function getAttemptStatistics($days = 30)
    {
        $dailyAttempts = $this->attempts()
            ->selectRaw('DATE(created_at) as date,
            COUNT(*) as total_attempts,
            SUM(CASE WHEN passed = 1 THEN 1 ELSE 0 END) as passed_attempts,
            SUM(CASE WHEN passed = 0 THEN 1 ELSE 0 END) as failed_attempts')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        return collect(range($days, 0, -1))->map(function ($day) use ($dailyAttempts) {
            $date = now()->subDays($day)->format('Y-m-d');
            $data = $dailyAttempts->get($date, new \stdClass());
            return [
                'date' => $date,
                'passed' => $data->passed_attempts ?? 0,
                'failed' => $data->failed_attempts ?? 0,
                'total' => $data->total_attempts ?? 0,
            ];
        });
    }

    public function getUserPerformanceDistribution()
    {
        return $this->attempts()
            ->where('status', 'completed')
            ->selectRaw(
                '
                COUNT(*) as total_attempts,
                SUM(CASE
                    WHEN score >= 90 THEN 1
                    ELSE 0
                END) as excellent,
                SUM(CASE
                    WHEN score >= 75 AND score < 90 THEN 1
                    ELSE 0
                END) as good,
                SUM(CASE
                    WHEN score >= 60 AND score < 75 THEN 1
                    ELSE 0
                END) as average,
                SUM(CASE
                    WHEN score < 60 THEN 1
                    ELSE 0
                END) as below_average'
            )
            ->first();
    }

    /**
     * Get question counts for multiple quizzes in a single query
     *
     * @param array $quizIds
     * @return \Illuminate\Support\Collection
     */
    public static function getQuestionCountsForQuizzes(array $quizIds)
    {
        return DB::table('quiz_questions')
            ->select(
                'quiz_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN type = "multiple_choice" THEN 1 ELSE 0 END) as multiple_choice'),
                DB::raw('SUM(CASE WHEN type = "true_false" THEN 1 ELSE 0 END) as true_false')
            )
            ->whereIn('quiz_id', $quizIds)
            ->groupBy('quiz_id')
            ->get()
            ->keyBy('quiz_id');
    }

    /**
     * Get performance stats for multiple quizzes in a single query
     *
     * @param array $quizIds
     * @return \Illuminate\Support\Collection
     */
    public static function getPerformanceStatsForQuizzes(array $quizIds)
    {
        return DB::table('quiz_attempts')
            ->select(
                'quiz_id',
                DB::raw('COUNT(*) as total_attempts'),
                DB::raw('SUM(CASE WHEN score >= 90 THEN 1 ELSE 0 END) as excellent'),
                DB::raw('SUM(CASE WHEN score >= 75 AND score < 90 THEN 1 ELSE 0 END) as good'),
                DB::raw('SUM(CASE WHEN score >= 60 AND score < 75 THEN 1 ELSE 0 END) as average'),
                DB::raw('SUM(CASE WHEN score < 60 THEN 1 ELSE 0 END) as below_average')
            )
            ->whereIn('quiz_id', $quizIds)
            ->where('status', 'completed')
            ->groupBy('quiz_id')
            ->get()
            ->keyBy('quiz_id');
    }

    /**
     * Get the count of questions for this quiz
     *
     * @return int
     */
    public function getQuestionsCountAttribute()
    {
        // If the questions are already loaded, use the collection count
        if ($this->relationLoaded('questions')) {
            return $this->questions->count();
        }

        return $this->questions()->count();
    }
}
