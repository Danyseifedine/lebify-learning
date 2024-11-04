<?php

namespace App\Http\Controllers\Dashboard\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseExtention;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseExtentionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $courses = Course::all();
        return view('dashboard.pages.courses.courseExtention', compact('user', 'courses'));
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
            'name' => 'required|string',
            'marketplace_url' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
        ]);

        CourseExtention::create($request->all());
        return response()->json(['message' => 'CourseExtention created successfully']);
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
            'name' => 'required|string',
            'marketplace_url' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
        ]);

        $courseextention = CourseExtention::find($request->id);
        $courseextention->update($request->all());
        return response()->json(['message' => 'CourseExtention updated successfully']);
    }

    public function getCourseExtention(string $id)
    {
        $courseextention = CourseExtention::find($id);
        return response()->json($courseextention);
    }

    public function changeStatus(string $id)
    {
        $courseextention = CourseExtention::find($id);
        $courseextention->is_published = !$courseextention->is_published;
        $courseextention->save();
        return response()->json(['message' => 'CourseExtention status changed successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $courseextention = CourseExtention::find($id);
        $courseextention->delete();
        return response()->json(['message' => 'CourseExtention deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $courseextentions = CourseExtention::with('course')->select(
            'id',
            'course_id',
            'name',
            'marketplace_url',
            'is_published',
            'created_at'
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('course', 'like', '%' . $value . '%')
                        ->orWhere('name', 'like', '%' . $value . '%')
                        ->orWhere('marketplace_url', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($courseextentions)
            ->addColumn('course_title', function ($courseExtention) {
                return $courseExtention->course->title ?? 'N/A';
            })
            ->make(true);
    }
}
