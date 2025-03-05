<?php

namespace App\Http\Controllers\Dashboard\Pages\Course;

use App\Http\Controllers\BaseController;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructors = Instructor::with('user')->get()->map(function ($instructor) {
            return [
                'id' => $instructor->id,
                'name' => $instructor->user->name
            ];
        });
        $user = auth()->user();
        return view('dashboard.pages.course.overview.index', compact('user', 'instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instructors = Instructor::all();
        return $this->componentResponse(view('dashboard.pages.course.overview.modal.create', compact('instructors')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'instructor_id' => 'required|exists:instructors,id',
            'description_en' => 'required|string',
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
        return $this->modalToastResponse('Course created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::find($id);
        return $this->componentResponse(view('dashboard.pages.course.overview.modal.show', compact('course')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::find($id);
        $instructors = Instructor::all();
        return $this->componentResponse(view('dashboard.pages.course.overview.modal.edit', compact('course', 'instructors')));
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
            'description_en' => 'required|string',
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
        return $this->modalToastResponse('Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::find($id);
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $courses = Course::with('instructor');

        // Filter by publication status
        if ($request->has('filter_is_published') && !$request->filter_is_published == null) {
            $courses->where('is_published', true);
        }

        if ($request->has('filter_is_not_published') && !$request->filter_is_not_published == null) {
            $courses->where('is_published', false);
        }

        if ($request->has('filter_instructor_id') && !$request->filter_instructor_id == null) {
            $courses->where('instructor_id', $request->filter_instructor_id);
        }

        $courses = $courses->select(
            'id',
            'title',
            'description_en',
            'views',
            'instructor_id',
            'duration',
            'difficulty_level',
            'is_published',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('title', 'like', '%' . $value . '%')
                        ->orWhere('description_en', 'like', '%' . $value . '%')
                        ->orWhere('views', 'like', '%' . $value . '%')
                        ->orWhere('instructor_id', 'like', '%' . $value . '%')
                        ->orWhere('duration', 'like', '%' . $value . '%')
                        ->orWhere('difficulty_level', 'like', '%' . $value . '%')
                        ->orWhere('is_published', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($courses->latest())
            ->editColumn('created_at', function ($course) {
                return $course->created_at->diffForHumans();
            })
            ->editColumn('instructor_id', function ($course) {
                return $course->instructor->user->name;
            })
            ->addColumn('image', function ($course) {
                $media = $course->getFirstMedia('course_images');
                if ($media) {
                    return '<img src="' . asset($media->getUrl()) . '" alt="' . $course->title . '" class="img-thumbnail" width="50">';
                }
                return 'No Image';
            })
            ->rawColumns(['image'])
            ->make(true);
    }

    public function changeStatus(string $id)
    {
        $course = Course::find($id);
        $course->is_published = !$course->is_published;
        $course->save();
        return response()->json(['message' => 'Course status changed successfully']);
    }

    public function preview(string $id)
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
}
