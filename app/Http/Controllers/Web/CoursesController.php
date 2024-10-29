<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseDocument;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    // courses
    public function courses()
    {
        $user = auth()->user();
        $role = $user->roles->first()->name;
        $courses = Course::with('media')->get();
        return view('web.courses.courses', compact('courses', 'role'));
    }

    // single course
    public function singleCourse($id)
    {
        $user = auth()->user();
        $role = $user->roles->first()->name;
        $course = Course::with('media')->find($id);
        $lessons = $course->lessons;
        $relatedChannels = $course->getRelatedChannels()->get();

        $course->views += 1;
        $course->save();
        $documents = $course->documents;

        // dd($documents);
        return view('web.courses.singleCourse', compact('course', 'role', 'documents', 'relatedChannels', 'lessons'));
    }

    // document
    public function document($course, $lang, $id, $order)
    {
        $user = auth()->user();
        $role = $user->roles->first()->name;
        $id = decrypt($id);
        $order = decrypt($order);

        $document = CourseDocument::where('id', $id)
            ->where('order', $order)
            ->firstOrFail();

        $prevDocument = CourseDocument::where('course_id', $document->course_id)
            ->where('order', $order - 1)
            ->first();

        $nextDocument = CourseDocument::where('course_id', $document->course_id)
            ->where('order', $order + 1)
            ->first();

        $content = $lang == 'ar' ? $document->content_ar : $document->content_en;

        return view('web.courses.document', compact('document', 'content', 'lang', 'order', 'course', 'prevDocument', 'nextDocument', 'role'));
    }
}
