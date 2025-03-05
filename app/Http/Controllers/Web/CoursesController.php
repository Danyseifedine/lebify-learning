<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Models\Course;
use App\Models\CourseDocument;
use Illuminate\Http\Request;

class CoursesController extends BaseController
{
    // courses
    public function courses()
    {
        $user = auth()->user();
        $role = $user->roles->first()->name;
        $coursesViewCount = Course::sum('views');
        $courses = Course::with('media')->get();
        return view('web.courses.index', compact('courses', 'user', 'role', 'coursesViewCount'));
    }

    // single course
    public function singleCourse($id)
    {
        $course = Course::with(['media', 'lessons', 'resources', 'documents'])
            ->findOrFail($id);

        $role = auth()->user()->roles->first()->name;

        $relatedChannels = $course->getRelatedChannels()->get();
        $course->increment('views');

        $lessons = $course->lessons;
        $resources = $course->resources;
        $documents = $course->documents;
        $extensions = $course->extensions;


        return view('web.courses.course', compact(
            'course',
            'role',
            'documents',
            'relatedChannels',
            'lessons',
            'resources',
            'extensions'
        ));
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

    public function filter(Request $request)
    {
        $courses = Course::filter($request->all())
            ->paginate(6);


        return $this->componentResponse(
            view('web.courses.partials.course-list', compact('courses'))
        );
    }
}
