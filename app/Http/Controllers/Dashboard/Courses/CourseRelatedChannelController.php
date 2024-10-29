<?php

namespace App\Http\Controllers\Dashboard\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRelatedChannel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseRelatedChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $courses = Course::all();
        return view('dashboard.pages.courses.courseRelatedChannel', compact('user', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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

        return response()->json(['message' => 'CourseRelatedChannel created successfully']);
    }

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

        return response()->json(['message' => 'CourseRelatedChannel updated successfully']);
    }

    public function getCourseRelatedChannel(string $id)
    {
        $CourseRelatedChannel = CourseRelatedChannel::find($id);
        return response()->json($CourseRelatedChannel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $courserelatedchannel = CourseRelatedChannel::find($id);
        $courserelatedchannel->delete();
        return response()->json(['message' => 'CourseRelatedChannel deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $courseRelatedChannels = CourseRelatedChannel::with('course')
            ->select(
                'id',
                'course_id',
                'channel_name',
                'url',
                'created_at'
            )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->whereHas('course', function ($q) use ($value) {
                        $q->where('title', 'like', '%' . $value . '%');
                    })
                        ->orWhere('channel_name', 'like', '%' . $value . '%')
                        ->orWhere('url', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($courseRelatedChannels)
            ->addColumn('course_title', function ($courseRelatedChannel) {
                return $courseRelatedChannel->course->title ?? 'N/A';
            })
            ->addColumn('image', function ($courseRelatedChannel) {
                $imageUrl = $courseRelatedChannel->getFirstMediaUrl('related_channels');
                return $imageUrl ? '<img src="' . $imageUrl . '" alt="Channel Image" class="img-thumbnail" width="100">' : 'No Image';
            })
            ->editColumn('created_at', function ($courseRelatedChannel) {
                return $courseRelatedChannel->created_at->diffForHumans();
            })
            ->rawColumns(['image'])
            ->make(true);
    }
}
