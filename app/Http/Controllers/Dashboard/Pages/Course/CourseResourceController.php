<?php

namespace App\Http\Controllers\Dashboard\Pages\Course;

use App\Http\Controllers\BaseController;
use App\Models\Course;
use App\Models\CourseResource;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseResourceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        $user = auth()->user();
        return view('dashboard.pages.course.resource.index', compact('user', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return $this->componentResponse(view('dashboard.pages.course.resource.modal.create', compact('courses')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|string',
            'title_en' => 'required|string',
            'url' => 'required|string',
        ]);

        CourseResource::create($request->all());
        return $this->modalToastResponse('CourseResource created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $courseResource = CourseResource::find($id);
        return $this->componentResponse(view('dashboard.pages.course.resource.modal.show', compact('courseResource')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $courses = Course::all();
        $courseResource = CourseResource::find($id);
        return $this->componentResponse(view('dashboard.pages.course.resource.modal.edit', compact('courseResource', 'courses')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate([
            'course_id' => 'required|string',
            'title_en' => 'required|string',
            'url' => 'required|string',
        ]);

        $courseResource = CourseResource::find($request->id);
        $courseResource->update($request->all());
        return $this->modalToastResponse('CourseResource updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $courseResource = CourseResource::find($id);
        $courseResource->delete();
        return response()->json(['message' => 'CourseResource deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $courseResources = CourseResource::select(
            'id',
            'course_id',
            'title_en',
            'url',
            'is_published',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('course_id', 'like', '%' . $value . '%')
                        ->orWhere('title_en', 'like', '%' . $value . '%')
                        ->orWhere('url', 'like', '%' . $value . '%')
                        ->orWhere('is_published', 'like', '%' . $value . '%');
                });
            });

        if ($request->has('filter_course_id') && !$request->filter_course_id == null) {
            $courseResources->where('course_id', $request->filter_course_id);
        }

        if ($request->has('filter_is_not_published') && !$request->filter_is_not_published == null) {
            $courseResources->where('is_published', false);
        }

        if ($request->has('filter_is_published') && !$request->filter_is_published == null) {
            $courseResources->where('is_published', true);
        }
        return DataTables::of($courseResources->latest())
            ->editColumn('created_at', function ($courseResource) {
                return $courseResource->created_at->diffForHumans();
            })
            ->editColumn('course_id', function ($courseResource) {
                return $courseResource->course->title;
            })
            ->make(true);
    }

    public function status(string $id)
    {
        $courseResource = CourseResource::find($id);
        $courseResource->is_published = !$courseResource->is_published;
        $courseResource->save();
        return response()->json(['message' => 'CourseResource status updated successfully']);
    }
}
