<?php

namespace App\Http\Controllers\Dashboard\Pages\Course;

use App\Http\Controllers\BaseController;
use App\Models\Course;
use App\Models\CourseExtention;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseExtentionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        $user = auth()->user();
        return view('dashboard.pages.course.extention.index', compact('user', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return $this->componentResponse(view('dashboard.pages.course.extention.modal.create', compact('courses')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string',
            'marketplace_url' => 'required|string',
        ]);

        CourseExtention::create($request->all());
        return $this->modalToastResponse('CourseExtention created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $courseExtention = CourseExtention::find($id);
        return $this->componentResponse(view('dashboard.pages.course.extention.modal.show', compact('courseExtention')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $courseExtention = CourseExtention::find($id);
        $courses = Course::all();
        return $this->componentResponse(view('dashboard.pages.course.extention.modal.edit', compact('courseExtention', 'courses')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string',
            'marketplace_url' => 'required|string',
        ]);

        $courseExtention = CourseExtention::find($request->id);
        $courseExtention->update($request->all());
        return $this->modalToastResponse('CourseExtention updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $courseExtention = CourseExtention::find($id);
        $courseExtention->delete();
        return response()->json(['message' => 'CourseExtention deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $courseExtentions = CourseExtention::select(
            'id',
            'course_id',
            'name',
            'description_en',
            'marketplace_url',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                        ->orWhere('description_en', 'like', '%' . $value . '%')
                        ->orWhere('marketplace_url', 'like', '%' . $value . '%');
                });
            });

        if ($request->has('filter_course_id') && !$request->filter_course_id == null) {
            $courseExtentions->where('course_id', $request->filter_course_id);
        }

        return DataTables::of($courseExtentions->latest())
            ->editColumn('created_at', function ($courseExtention) {
                return $courseExtention->created_at->diffForHumans();
            })
            ->editColumn('course_id', function ($courseExtention) {
                return $courseExtention->course->title;
            })
            ->make(true);
    }
}
