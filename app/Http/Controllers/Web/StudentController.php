<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Models\Course;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends BaseController
{


    // login
    public function login(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'password' => 'required',
        ]);

        $uuid = $request->uuid;
        $password = $request->password;

        $student = User::where('uuid', $uuid)->first();

        if (!$student || !Hash::check($password, $student->password) || $student->status == 'inactive') {
            return response()->json([
                'success' => false,
                'errors' => [
                    'uuid' => ['The provided UUID or password is incorrect.'],
                ]
            ], 422);
        }

        $student->login_count += 1;
        $student->save();

        auth()->login($student);

        return $this->modalToastResponse(__('common.login_successful'));
    }

    // feedback
    public function feedback(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'subject' => 'required|in:course_inquiry,technical_support,partnership,feedback,other|max:255',
        ]);

        Feedback::create($request->all());

        return $this->successToastResponse(__('common.feedback_submitted_successfully'));
    }

    // profile
    public function profile()
    {
        $user = auth()->user();
        $roles = $user->roles;

        $role = $roles->first()->name;

        return view('web.user.profile', compact('user', 'role'));
    }

    // profile tabs
    public function profileTabs(Request $request)
    {
        $tab = $request->tabId;
        $user = auth()->user();
        $view = view('web.user.tabs.' . $tab, compact('user'));
        return $this->tabContentResponse($view);
    }

    // update settings
    public function updateSettings(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'nullable|string',
        ]);

        $updateData = [
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $user->update($updateData);

        return $this->successToastResponse(__('common.settings_updated_successfully'));
    }

    // courses
    public function courses()
    {
        $user = auth()->user();
        $role = $user->roles->first()->name;
        $courses = Course::with('media')->get();
        return view('web.courses.courses', compact('courses', 'role'));
    }

    // single course
    public function singleCourse($id)
    {
        $user = auth()->user();
        $role = $user->roles->first()->name;
        $course = Course::with('media')->find($id);
        $documents = $course->documents;

        // dd($documents);
        return view('web.courses.singleCourse', compact('course', 'role', 'documents'));
    }
}
