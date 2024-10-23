<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['title', 'description', 'instructor_id', 'duration'];

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
}
