<?php

namespace App\Http\Controllers\Dashboard\Pages\Course;

use App\Http\Controllers\BaseController;
use App\Models\CourseLesson;
use App\Models\Course;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseLessonController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        $user = auth()->user();
        return view('dashboard.pages.course.lesson.index', compact('user', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return $this->componentResponse(view('dashboard.pages.course.lesson.modal.create', compact('courses')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string',
            'duration' => 'required|integer',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $courseLesson = CourseLesson::create($request->except('thumbnail'));

        if ($request->hasFile('thumbnail')) {
            $courseLesson->addMedia($request->file('thumbnail'))
                ->toMediaCollection('thumbnails');
        }

        return $this->modalToastResponse('Course Lesson created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $courseLesson = CourseLesson::find($id);
        return $this->componentResponse(view('dashboard.pages.course.lesson.modal.show', compact('courseLesson')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $courses = Course::all();
        $courseLesson = CourseLesson::find($id);
        return $this->componentResponse(view('dashboard.pages.course.lesson.modal.edit', compact('courseLesson', 'courses')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string',
            'duration' => 'required|integer',
            'thumbnail' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $courseLesson = CourseLesson::find($request->id);
        $courseLesson->update($request->except('thumbnail'));

        if ($request->hasFile('thumbnail')) {
            $courseLesson->clearMediaCollection('thumbnails');
            $courseLesson->addMedia($request->file('thumbnail'))
                ->toMediaCollection('thumbnails');
        }

        return $this->modalToastResponse('Course Lesson updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $courseLesson = CourseLesson::find($id);
        $courseLesson->delete();
        return response()->json(['message' => 'Course Lesson deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $courseLessons = CourseLesson::with('course')
            ->select(
                'id',
                'course_id',
                'title',
                'duration',
                'is_published',
                'views_count',
            )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('course_id', 'like', '%' . $value . '%')
                        ->orWhere('title', 'like', '%' . $value . '%')
                        ->orWhere('duration', 'like', '%' . $value . '%')
                        ->orWhere('is_published', 'like', '%' . $value . '%')
                        ->orWhere('views_count', 'like', '%' . $value . '%');
                });
            });

        if ($request->has('filter_course_id') && !$request->filter_course_id == null) {
            $courseLessons->where('course_id', $request->filter_course_id);
        }

        if ($request->has('filter_is_published') && !$request->filter_is_published == null) {
            $courseLessons->where('is_published', true);
        }

        if ($request->has('filter_is_not_published') && !$request->filter_is_not_published == null) {
            $courseLessons->where('is_published', false);
        }

        return DataTables::of($courseLessons->latest())
            ->editColumn('course_id', function ($courseLesson) {
                return $courseLesson->course->title;
            })
            ->addColumn('thumbnail', function ($courseLesson) {
                $imageUrl = $courseLesson->getThumbnailUrlAttribute();
                return $imageUrl ? '<img src="' . $imageUrl . '" alt="Thumbnail" class="img-fluid" style="max-width: 100px;">' : 'N/A';
            })
            ->rawColumns(['thumbnail'])
            ->make(true);
    }

    public function status(string $id)
    {
        $courseLesson = CourseLesson::find($id);
        $courseLesson->is_published = !$courseLesson->is_published;
        $courseLesson->save();
        return response()->json(['message' => 'Course Lesson status updated successfully']);
    }
}
