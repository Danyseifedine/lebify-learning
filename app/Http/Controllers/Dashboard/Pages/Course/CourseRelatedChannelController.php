<?php

namespace App\Http\Controllers\Dashboard\Pages\Course;

use App\Http\Controllers\BaseController;
use App\Models\Course;
use App\Models\CourseRelatedChannel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseRelatedChannelController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        $user = auth()->user();
        return view('dashboard.pages.course.relatedChannel.index', compact('user', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return $this->componentResponse(view('dashboard.pages.course.relatedChannel.modal.create', compact('courses')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'channel_name' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'required|url',
        ]);

        $courseRelatedChannel = CourseRelatedChannel::create([
            'course_id' => $request->course_id,
            'channel_name' => $request->channel_name,
            'url' => $request->url,
        ]);

        if ($request->hasFile('image')) {
            $courseRelatedChannel->addMedia($request->file('image'))
                ->toMediaCollection('related_channels');
        }

        return $this->modalToastResponse('CourseRelatedChannel created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $courses = Course::all();
        $courseRelatedChannel = CourseRelatedChannel::find($id);
        return $this->componentResponse(view('dashboard.pages.course.relatedChannel.modal.show', compact('courseRelatedChannel', 'courses')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $courses = Course::all();
        $courseRelatedChannel = CourseRelatedChannel::find($id);
        return $this->componentResponse(view('dashboard.pages.course.relatedChannel.modal.edit', compact('courseRelatedChannel', 'courses')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'channel_name' => 'required|string',
            'url' => 'required|url',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $courseRelatedChannel = CourseRelatedChannel::findOrFail($request->id);
        $courseRelatedChannel->update([
            'course_id' => $request->course_id,
            'channel_name' => $request->channel_name,
            'url' => $request->url,
        ]);

        if ($request->hasFile('image')) {
            $courseRelatedChannel->addMedia($request->file('image'))
                ->toMediaCollection('related_channels');
        }
        return $this->modalToastResponse('Course Related Channel updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $courseRelatedChannel = CourseRelatedChannel::find($id);
        $courseRelatedChannel->delete();
        return response()->json(['message' => 'Course Related Channel deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $courseRelatedChannels = CourseRelatedChannel::with('course')->select(
            'id',
            'course_id',
            'channel_name',
            'url',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('course_id', 'like', '%' . $value . '%')
                        ->orWhere('channel_name', 'like', '%' . $value . '%')
                        ->orWhere('url', 'like', '%' . $value . '%');
                });
            });

        if ($request->has('filter_course_id') && !$request->filter_course_id == null) {
            $courseRelatedChannels->where('course_id', $request->filter_course_id);
        }

        return DataTables::of($courseRelatedChannels->latest())
            ->addColumn('image', function ($courseRelatedChannel) {
                $imageUrl = $courseRelatedChannel->getFirstMediaUrl('related_channels');
                return $imageUrl ? '<img src="' . $imageUrl . '" alt="Channel Image" class="img-thumbnail" width="100">' : 'No Image';
            })
            ->rawColumns(['image'])
            ->editColumn('created_at', function ($courseRelatedChannel) {
                return $courseRelatedChannel->created_at->diffForHumans();
            })
            ->editColumn('course_id', function ($courseRelatedChannel) {
                return $courseRelatedChannel->course->title;
            })
            ->make(true);
    }
}
