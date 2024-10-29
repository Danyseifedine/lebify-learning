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
        'description_ar',
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
        return app()->getLocale() == 'ar' ? $this->description_ar : $this->description_en;
    }

    public function getThumbnailAttribute()
    {
        return $this->getMedia('thumbnails')->first();
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->getFirstMediaUrl('thumbnails');
    }

    public function getEmbedVideoUrlAttribute()
    {
        // If URL is empty, return null
        if (empty($this->video_url)) {
            return null;
        }

        // Handle YouTube URLs
        if (strpos($this->video_url, 'youtube.com') !== false || strpos($this->video_url, 'youtu.be') !== false) {
            // Extract video ID using regex pattern
            $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';

            if (preg_match($pattern, $this->video_url, $matches)) {
                $videoId = $matches[1];

                // Most privacy-focused embed URL
                return "https://www.youtube-nocookie.com/embed/{$videoId}/?" . http_build_query([
                    'cc_load_policy' => 1,
                    'modestbranding' => 1,
                    'rel' => 0,
                    'controls' => 1,
                ]);
            }
        }

        return $this->video_url;
    }
}
