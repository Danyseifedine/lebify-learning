<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['title', 'description', 'instructor_id', 'duration', 'difficulty_level', 'is_published'];

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
        return match ($this->difficulty_level) {
            1 => '#4CAF50', // Easy - Green
            2 => '#8BC34A', // Fairly Easy - Light Green
            3 => '#FFC107', // Moderate - Amber
            4 => '#FF9800', // Challenging - Orange
            5 => '#F44336', // Difficult - Red
            default => '#9E9E9E', // Default - Grey
        };
    }

    public function getDifficultyPercentage()
    {
        return $this->difficulty_level * 20;
    }
}
