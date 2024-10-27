<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CourseRelatedChannel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['course_id', 'channel_name', 'url'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('related_channels')->singleFile();
    }

    public function getUrl()
    {
        return $this->getFirstMediaUrl('related_channels');
    }
}
