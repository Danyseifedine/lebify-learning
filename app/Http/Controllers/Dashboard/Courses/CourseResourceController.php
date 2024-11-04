<?php

namespace App\Http\Controllers\Dashboard\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseResource;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $courses = Course::all();
        return view('dashboard.pages.courses.courseResource', compact('user', 'courses'));
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
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'url' => 'required|string',
        ]);

        CourseResource::create($request->all());
        return response()->json(['message' => 'CourseResource created successfully']);
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

    public function changeStatus(string $id)
    {
        $courseResource = CourseResource::find($id);
        $courseResource->is_published = !$courseResource->is_published;
        $courseResource->save();
        return response()->json(['message' => 'CourseResource status changed successfully']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {       
        $request->validate([
            'course_id' => 'required|string',
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'url' => 'required|string',
        ]);

        $courseResource = CourseResource::find($request->id);
        $courseResource->update($request->all());
        return response()->json(['message' => 'CourseResource updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $courseresource = CourseResource::find($id);
        $courseresource->delete();
        return response()->json(['message' => 'CourseResource deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $courseresources = CourseResource::with('course')->select(
            'id',
            'course_id',
            'title_en',
            'url',
            'is_published',
            'created_at'
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('course', 'like', '%' . $value . '%')
                        ->orWhere('title_en', 'like', '%' . $value . '%')
                        ->orWhere('url', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($courseresources)
            ->addColumn('course_title', function ($courseResource) {
                return $courseResource->course->title ?? 'N/A';
            })
            ->make(true);
    }


    public function getCourseResource(string $id)
    {
        $CourseResource = CourseResource::find($id);
        return response()->json($CourseResource);
    }
}
