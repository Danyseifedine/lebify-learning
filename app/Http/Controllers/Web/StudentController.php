<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Models\Course;
use App\Models\CourseDocument;
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

    public function getProfileQuizzes()
    {
        $user = auth()->user();

        $data = [
            'attempts' => $user->quizAttemptsWithQuiz()
                ->take(10)
                ->get(),
            'scoreStatistics' => $user->getQuizStatusStatistics(7)
        ];

        $recentView = view('web.user.tabs.quizzesComponents.recentAttempt', [
            'attempts' => $data['attempts']
        ]);

        $analysisView = view('web.user.tabs.quizzesComponents.analysis', [
            'attempts' => $data['attempts'],
            'scoreStatistics' => $data['scoreStatistics']
        ])->render();

        return $this->componentResponse($recentView, ['analysis' => $analysisView]);
    }

    // update settings
    public function updateSettings(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
            'new-password' => 'required|min:8|different:password',
        ]);

        $user = auth()->user();


        $user->update([
            'password' => bcrypt($request->input('new-password'))
        ]);

        return $this->successToastResponse(__('common.settings_updated_successfully'));
    }

    public function createWallet()
    {
        $user = auth()->user();
        $role = $user->roles->first()->name;
        if ($user->hasCoinWallet()) {
            return redirect()->route('profile');
        }

        return view('web.coinWallet.createWallet', compact('role'));
    }
}
