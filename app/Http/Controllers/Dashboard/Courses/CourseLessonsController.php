<?php

namespace App\Http\Controllers\Dashboard\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseLessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $courses = Course::all();
        return view('dashboard.pages.courses.courseLesson', compact('user', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|string',
            'title' => 'required|string',
            'language' => 'required|string',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'duration' => 'required|string',
            'video_url' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $courseLesson = CourseLesson::create($request->except('thumbnail'));

        if ($request->hasFile('thumbnail')) {
            $courseLesson->addMedia($request->file('thumbnail'))
                ->toMediaCollection('thumbnails');
        }

        return response()->json(['message' => 'CourseLesson created successfully']);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'course_id' => 'required|string',
            'title' => 'required|string',
            'language' => 'required|string',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'duration' => 'required|string',
            'video_url' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $courseLesson = CourseLesson::find($request->id);
        $courseLesson->update($request->except('thumbnail'));

        if ($request->hasFile('thumbnail')) {
            $courseLesson->clearMediaCollection('thumbnails');
            $courseLesson->addMedia($request->file('thumbnail'))
                ->toMediaCollection('thumbnails');
        }
        return response()->json(['message' => 'CourseLesson updated successfully']);
    }

    public function getCourseLesson(string $id)
    {
        $CourseLesson = CourseLesson::find($id);
        return response()->json($CourseLesson);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $courselesson = CourseLesson::find($id);
        $courselesson->delete();
        return response()->json(['message' => 'CourseLesson deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $courseLessons = CourseLesson::with('course')
            ->select(
                'course_lessons.id',
                'course_lessons.title',
                'course_lessons.video_url',
                'course_lessons.is_published',
                'course_lessons.course_id'
            )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('title', 'like', '%' . $value . '%')
                        ->orWhereHas('course', function ($q) use ($value) {
                            $q->where('title', 'like', '%' . $value . '%');
                        });
                });
            });

        return DataTables::of($courseLessons)
            ->addColumn('course', function ($courseLesson) {
                return $courseLesson->course->title ?? 'N/A';
            })
            ->addColumn('thumbnail', function ($courseLesson) {
                $imageUrl = $courseLesson->getThumbnailUrlAttribute();
                return $imageUrl ? '<img src="' . $imageUrl . '" alt="Thumbnail" class="img-fluid" style="max-width: 100px;">' : 'N/A';
            })
            ->rawColumns(['thumbnail'])
            ->make(true);
    }

    public function changeStatus(string $id)
    {
        $courseLesson = CourseLesson::find($id);
        $courseLesson->is_published = !$courseLesson->is_published;
        $courseLesson->save();
        return response()->json(['message' => 'CourseLesson status changed successfully']);
    }
}
