<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Course extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;



    protected $fillable = ['title', 'description_ar', 'description_en', 'color', 'views', 'instructor_id', 'duration', 'difficulty_level', 'is_published'];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function documents()
    {
        return $this->hasMany(CourseDocument::class);
    }

    public function getInstructorName()
    {
        return $this->instructor->name;
    }

    public function addThumbnail($file)
    {
        return $this->addMedia($file)->toMediaCollection('thumbnails');
    }

    public function getThumbnail()
    {
        return $this->getFirstMediaUrl('thumbnails');
    }

    public function getDifficultyColor()
    {
        $colors = [
            1 => '#4CAF50',
            2 => '#8BC34A',
            3 => '#FFC107',
            4 => '#FF9800',
            5 => '#F44336'
        ];

        return $colors[$this->difficulty_level] ?? '#9E9E9E';
    }

    public function getDifficultyPercentage()
    {
        return $this->difficulty_level * 20;
    }

    public function getDescription($withLimit = true)
    {
        return $withLimit ? (app()->getLocale() == 'ar' ? Str::limit($this->description_ar, 100) : Str::limit($this->description_en, 100)) : (app()->getLocale() == 'ar' ? $this->description_ar : $this->description_en);
    }

    public function getRelatedChannels()
    {
        return $this->hasMany(CourseRelatedChannel::class);
    }
}
