<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;


    protected $fillable = [
        'quiz_id',
        'user_id',
        'started_at',
        'completed_at',
        'score',
        'passed',
        'reason',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responses()
    {
        return $this->hasMany(QuizResponse::class, 'attempt_id');
    }

    public function isCompletedOrInvalid()
    {
        return $this->status == 'completed' || $this->status == 'aborted' || $this->status == 'timeout';
    }

    public function belongsToUser($userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $this->user_id == $userId;
    }

    public static function abortPendingAttempts($userId = null)
    {
        $userId = $userId ?? auth()->id();

        return static::where('user_id', $userId)
            ->where('status', 'pending')
            ->update([
                'status' => 'aborted',
                'completed_at' => now()
            ]);
    }

    public function getCorrectAnswersCount()
    {
        return $this->responses()
            ->whereHas('answer', function ($query) {
                $query->where('is_correct', true);
            })
            ->count();
    }

    public function getIncorrectAnswersCount()
    {
        return $this->responses()->whereHas('answer', function ($query) {
            $query->where('is_correct', false);
        })->count();
    }

    public function getScore()
    {
        $totalQuestions = $this->quiz->questions()->count();
        if ($totalQuestions == 0) {
            return 0;
        }

        $correctAnswers = $this->getCorrectAnswersCount();
        $score = ($correctAnswers / $totalQuestions) * 100;

        return intval($score);
    }

    public function isPassed()
    {
        return $this->getScore() >= $this->quiz->passing_score;
    }
}
