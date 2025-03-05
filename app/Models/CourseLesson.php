<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseLesson extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'course_id',
        'title',
        'description_en',
        'video_url',
        'duration',
        'language',
        'is_published',
        'views_count'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'duration' => 'integer',
        'views_count' => 'integer'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function getDurationForHumansAttribute()
    {
        if (!$this->duration) return 'N/A';

        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }

        return "{$minutes}m";
    }

    public function getDescriptionAttribute()
    {
        return $this->description_en;
    }

    public function getThumbnailAttribute()
    {
        return $this->getMedia('thumbnails')->first();
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->getFirstMediaUrl('thumbnails');
    }

}
