<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DifficultyLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'name',
    ];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function getDifficultyImage()
    {
        $difficultyImages = [
            'Beginner' => 'beginner',
            'Intermediate' => 'intermediate',
            'Advanced' => 'advanced'
        ];
        return $difficultyImages[$this->name];
    }

    public function getDifficultyName()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name;
    }
}
