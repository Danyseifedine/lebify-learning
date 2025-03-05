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

    protected $fillable = ['title', 'description_en', 'color', 'views', 'instructor_id', 'duration', 'difficulty_level', 'is_published'];

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
        return $withLimit ? Str::limit($this->description_en, 100) : $this->description_en;
    }

    public function getRelatedChannels()
    {
        return $this->hasMany(CourseRelatedChannel::class);
    }

    public function lessons()
    {
        return $this->hasMany(CourseLesson::class);
    }

    public function resources()
    {
        return $this->hasMany(CourseResource::class);
    }

    public function extensions()
    {
        return $this->hasMany(CourseExtention::class);
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['name'])) {
            $query->where('title', 'like', '%' . $filters['name'] . '%');
        }
        if (isset($filters['difficulty_level'])) {
            $query->where('difficulty_level', $filters['difficulty_level']);
        }
        if (isset($filters['published_date'])) {
            if ($filters['published_date'] == 'today') {
                $query->where('created_at', '>=', now()->startOfDay());
            } elseif ($filters['published_date'] == 'this_week') {
                $query->where('created_at', '>=', now()->startOfWeek());
            } elseif ($filters['published_date'] == 'this_month') {
                $query->where('created_at', '>=', now()->startOfMonth());
            } elseif ($filters['published_date'] == 'last_3_months') {
                $query->where('created_at', '>=', now()->subMonths(3));
            } elseif ($filters['published_date'] == 'this_year') {
                $query->where('created_at', '>=', now()->startOfYear());
            }
        }
        if (isset($filters['sort_by'])) {
            if ($filters['sort_by'] == 'oldest') {
                $query->orderBy('created_at', 'asc');
            } elseif ($filters['sort_by'] == 'difficulty_asc') {
                $query->orderBy('difficulty_level', 'asc');
            } elseif ($filters['sort_by'] == 'difficulty_desc') {
                $query->orderBy('difficulty_level', 'desc');
            } elseif ($filters['sort_by'] == 'duration_asc') {
                $query->orderBy('duration', 'asc');
            } elseif ($filters['sort_by'] == 'duration_desc') {
                $query->orderBy('duration', 'desc');
            }
        }

        if (isset($filters['duration_min'])) {
            $query->where('duration', '>=', $filters['duration_min']);
        }
        if (isset($filters['duration_max'])) {
            $query->where('duration', '<=', $filters['duration_max']);
        }

        return $query;
    }
}
