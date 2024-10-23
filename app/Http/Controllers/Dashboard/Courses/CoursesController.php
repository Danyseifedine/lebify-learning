<?php

namespace App\Http\Controllers\Dashboard\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Yajra\DataTables\Facades\DataTables;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $instructors = Instructor::all();
        return view('dashboard.pages.courses.courses', compact('user', 'instructors'));
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
            'title' => 'required|string',
            'instructor_id' => 'required|exists:instructors,id',
            'description' => 'required|string',
            'duration' => 'required|string',
            'difficulty_level' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $course = Course::create($request->except('image'));
        if ($request->hasFile('image')) {
            try {
                $course->addMediaFromRequest('image')
                    ->toMediaCollection('course_images');
            } catch (FileDoesNotExist $e) {
                return response()->json(['error' => 'File does not exist'], 400);
            } catch (FileIsTooBig $e) {
                return response()->json(['error' => 'File is too big'], 400);
            }
        }
        return response()->json(['message' => 'Courses created successfully']);
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
            'id' => 'required|exists:courses,id',
            'title' => 'required|string',
            'instructor_id' => 'required|exists:instructors,id',
            'description' => 'required|string',
            'difficulty_level' => 'required|string',
            'duration' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $course = Course::findOrFail($request->id);

        $course->update($request->except('image'));

        if ($request->hasFile('image')) {
            try {
                $course->clearMediaCollection('course_images');

                $course->addMediaFromRequest('image')
                    ->toMediaCollection('course_images');
            } catch (FileDoesNotExist $e) {
                return response()->json(['message' => 'Error uploading image: File does not exist'], 400);
            } catch (FileIsTooBig $e) {
                return response()->json(['message' => 'Error uploading image: File is too big'], 400);
            }
        }

        return response()->json(['message' => 'Course updated successfully']);
    }


    public function getCourses(string $id)
    {
        $Courses = Course::find($id);
        return response()->json($Courses);
    }

    public function changeStatus(string $id)
    {
        $course = Course::find($id);
        $course->is_published = !$course->is_published;
        $course->save();
        return response()->json(['message' => 'Course status changed successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $courses = Course::find($id);
        $courses->delete();
        return response()->json(['message' => 'Courses deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $courses = Course::select(
            'courses.id',
            'courses.title',
            'courses.duration',
            'courses.is_published',
            'courses.created_at',
            'users.name as instructor_name'
        )
            ->join('instructors', 'courses.instructor_id', '=', 'instructors.id')
            ->join('users', 'instructors.user_id', '=', 'users.id')
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('courses.title', 'like', '%' . $value . '%')
                        ->orWhere('users.name', 'like', '%' . $value . '%')
                        ->orWhere('courses.duration', 'like', '%' . $value . '%')
                        ->orWhere('courses.is_published', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($courses)
            ->addColumn('instructor_name', function ($course) {
                return $course->instructor_name;
            })

            ->addColumn('image', function ($course) {
                $media = $course->getFirstMedia('course_images');
                if ($media) {
                    return '<img src="' . asset($media->getUrl()) . '" alt="' . $course->title . '" class="img-thumbnail" width="50">';
                }
                return 'No Image';
            })
            ->editColumn('created_at', function ($course) {
                return $course->created_at->diffForHumans();
            })
            ->rawColumns(['image'])
            ->make(true);
    }
}
