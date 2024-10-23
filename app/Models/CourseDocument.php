<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseDocument extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title_en', 'title_ar', 'content_en', 'content_ar', 'order'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function getTitle($lang = 'en')
    {
        return $lang == 'en' ? $this->title_en : $this->title_ar;
    }

    public function getContent($lang = 'en')
    {
        return $lang == 'en' ? $this->content_en : $this->content_ar;
    }
}
