<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;


    protected $fillable = [
        'quiz_id',
        'category_id',
        'question',
        'type',
        'order'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function category()
    {
        return $this->belongsTo(QuestionCategory::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'question_id');
    }

    public function responses()
    {
        return $this->hasMany(QuizResponse::class, 'question_id');
    }

    public function getCorrectAnswer()
    {
        return $this->answers()->where('is_correct', true)->first();
    }
}
