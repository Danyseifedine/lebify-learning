<?php

namespace App\Http\Controllers\Dashboard\Pages\Course;

use App\Http\Controllers\BaseController;
use App\Models\Course;
use App\Models\CourseDocument;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseDocumentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $courses = Course::all();
        return view('dashboard.pages.course.document.index', compact('user', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return $this->componentResponse(view('dashboard.pages.course.document.modal.create', compact("courses")));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|string',
            'title_en' => 'required|string',
            'content_en' => 'required|string',
            'content_ar' => 'required|string',
            'order' => 'required|string',
        ]);
        CourseDocument::create($request->all());
        return $this->modalToastResponse('Course Document created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $courseDocument = CourseDocument::find($id);
        return $this->componentResponse(view('dashboard.pages.course.document.modal.show', compact('courseDocument')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $courses = Course::all();
        $courseDocument = CourseDocument::find($id);
        $content_en = $courseDocument->content_en;
        $content_ar = $courseDocument->content_ar;
        $view = view('dashboard.pages.course.document.modal.edit', compact('courseDocument', 'courses', 'content_en', 'content_ar'))->render();
        return $this->successResponse(['html' => $view, 'content_en' => $content_en, 'content_ar' => $content_ar]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'course_id' => 'required|string',
            'title_en' => 'required|string',
            'content_en' => 'required|string',
            'content_ar' => 'required|string',
            'order' => 'required|string',
        ]);

        $courseDocument = CourseDocument::find($request->id);
        $courseDocument->update($request->all());
        return $this->modalToastResponse('CourseDocument updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $courseDocument = CourseDocument::find($id);
        $courseDocument->delete();
        return response()->json(['message' => 'CourseDocument deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $courseDocuments = CourseDocument::with('course')->select(
            'id',
            'course_id',
            'title_en',
            'content_en',
            'content_ar',
            'order',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('course_id', 'like', '%' . $value . '%')
                        ->orWhere('title_en', 'like', '%' . $value . '%')
                        ->orWhere('order', 'like', '%' . $value . '%');
                });
            });

        if ($request->has('filter_course_id') && !$request->filter_course_id == null) {
            $courseDocuments->where('course_id', $request->filter_course_id);
        }

        if ($request->has('filter_is_published') && !$request->filter_is_published == null) {
            $courseDocuments->where('is_published', true);
        }

        if ($request->has('filter_is_not_published') && !$request->filter_is_not_published == null) {
            $courseDocuments->where('is_published', false);
        }

        return DataTables::of($courseDocuments->latest())
            ->editColumn('created_at', function ($courseDocument) {
                return $courseDocument->created_at->diffForHumans();
            })
            ->addColumn('course_id', function ($courseDocument) {
                return $courseDocument->course->title;
            })
            ->rawColumns(['course_id'])
            ->make(true);
    }
}
