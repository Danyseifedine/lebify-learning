<?php

namespace App\Http\Controllers\Dashboard\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseDocument;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseDocumentsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $courses = Course::all();
        return view('dashboard.pages.courses.courseDocuments', compact('user', 'courses'));
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
            'content_en' => 'required|string',
            'content_ar' => 'required|string',
            'order' => 'required|string',
        ]);

        CourseDocument::create($request->all());
        return response()->json(['message' => 'CourseDocuments created successfully']);
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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'course_id' => 'required|string',
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'content_en' => 'required|string',
            'content_ar' => 'required|string',
            'order' => 'required|string',
        ]);

        $courseDocument = CourseDocument::findOrFail($id);
        $courseDocument->update($request->all());
        return response()->json(['message' => 'CourseDocuments updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coursedocuments = CourseDocument::find($id);
        $coursedocuments->delete();
        return response()->json(['message' => 'CourseDocuments deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $courseDocuments = CourseDocument::select(
            'course_documents.id',
            'course_documents.title_en',
            'course_documents.order',
            'course_documents.course_id',
            'courses.title as course_title'
        )
            ->join('courses', 'course_documents.course_id', '=', 'courses.id')
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('courses.title', 'like', '%' . $value . '%')
                        ->orWhere('course_documents.title_en', 'like', '%' . $value . '%')
                        ->orWhere('course_documents.order', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($courseDocuments)
            ->addColumn('course', function ($courseDocument) {
                return $courseDocument->course_title;
            })
            ->make(true);
    }

    public function getCourseDocuments(string $id)
    {
        $CourseDocuments = CourseDocument::find($id);
        return response()->json($CourseDocuments);
    }
}
