<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;

class CourseDocument extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title_en', 'description_en', 'content_en', 'content_ar', 'order'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function getTitle()
    {
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getDescription()
    {
        return app()->getLocale() == 'ar' ? $this->description_ar : $this->description_en;
    }

    public function getContent($lang = 'en')
    {
        return $lang == 'en' ? $this->content_en : $this->content_ar;
    }
}
