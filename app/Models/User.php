<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\HasRolesAndPermissions;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'uuid',
        'phone',
        'age',
        'email_verified_at',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userCanManageUsers()
    {
        return $this->isAbleTo('manage-users');
    }

    public function userCanManageInstructors()
    {
        return $this->isAbleTo('manage-instructors');
    }

    public function userCanManageCourses()
    {
        return $this->isAbleTo('manage-courses');
    }

    public function userCanManageQuizzes()
    {
        return $this->isAbleTo('manage-quizzes');
    }

    public function canManagePrivileges()
    {
        return $this->isAbleTo('manage-privileges');
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function isInstructor()
    {
        return $this->instructor()->exists();
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class, 'user_id');
    }

    public function quizAttemptsWithQuiz()
    {
        return $this->quizAttempts()
            ->with(['quiz' => function ($query) {
                $query->with(['duration', 'difficultyLevel']);
            }])
            ->latest();
    }

    public function getAttemptsCount()
    {
        return $this->quizAttempts()->count();
    }

    public function hasReachedMaxAttempts($quizId)
    {
        $quiz = Quiz::find($quizId);
        $attemptsCount = $this->quizAttempts()
            ->where('quiz_id', $quizId)
            ->count();

        return $attemptsCount >= $quiz->attempts_allowed;
    }

    public function getQuizStatusStatistics($days = 7)
    {
        return $this->quizAttempts()
            ->selectRaw('DATE(created_at) as date,
                SUM(CASE WHEN passed = 1 THEN 1 ELSE 0 END) as passed_count,
                SUM(CASE WHEN passed = 0 AND status != "aborted" THEN 1 ELSE 0 END) as failed_count,
                SUM(CASE WHEN status = "aborted" THEN 1 ELSE 0 END) as aborted_count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($stat) {
                return [
                    'date' => $stat->date,
                    'passed' => (int)$stat->passed_count,
                    'failed' => (int)$stat->failed_count,
                    'aborted' => (int)$stat->aborted_count
                ];
            });
    }

    public function coinWallet()
    {
        return $this->hasOne(CoinWallet::class);
    }

    public function hasCoinWallet()
    {
        return $this->coinWallet()->exists();
    }

    public function coinTransactions()
    {
        return $this->hasManyThrough(
            CoinTransaction::class,
            CoinWallet::class,
            'user_id',
            'wallet_id'
        );
    }
}
