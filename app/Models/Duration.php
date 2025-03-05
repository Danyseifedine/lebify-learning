<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    use HasFactory;

    protected $fillable = [
        'minutes',
        'name',
    ];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function getDurationImage()
    {
        $durationImages = [
            'Blitz' => 'blitz',
            'Bullet' => 'bullet',
            'Rapid' => 'rapid'
        ];

        return $durationImages[$this->name];
    }


    public function formatDuration()
    {
        if ($this->minutes == 1) {
            return app()->getLocale() == 'ar' ? 'دقيقة واحدة' : '1 minute';
        }
        if ($this->minutes == 2) {
            return app()->getLocale() == 'ar' ? 'دقيقتين' : '2 minutes';
        }
        return app()->getLocale() == 'ar' ? $this->minutes . ' دقائق' : $this->minutes . ' minutes';
    }

    public function getDurationName()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name;
    }
}
