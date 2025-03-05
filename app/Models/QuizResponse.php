<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResponse extends Model
{
    use HasFactory;


    protected $fillable = [
        'attempt_id',
        'question_id',
        'answer_id',
        'text_answer',
        'is_correct'
    ];

    public function attempt()
    {
        return $this->belongsTo(QuizAttempt::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(QuizAnswer::class, 'answer_id');
    }

    public function isAnswerCorrect()
    {
        return $this->answer->is_correct;
    }

}
