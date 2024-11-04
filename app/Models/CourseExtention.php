<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseExtention extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'description_en',
        'description_ar',
        'marketplace_url',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getDescription()
    {
        return app()->getLocale() == 'en' ? $this->description_en : $this->description_ar;
    }

    public function randomColor()
    {
        $colors = [
            '#2196F3', // blue
            '#4CAF50', // green  
            '#F44336', // red
            '#9C27B0', // purple
            '#FF9800'  // orange
        ];
        
        return $colors[array_rand($colors)];
    }
}
