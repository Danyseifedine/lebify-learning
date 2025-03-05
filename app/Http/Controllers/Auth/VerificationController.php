<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends BaseController
{
    /*
            |--------------------------------------------------------------------------
            | Email Verification Controller
            |--------------------------------------------------------------------------
            |
            | This controller is responsible for handling email verification for any
            | user that recently registered with the application. Emails may also
            | be re-sent if the user didn't receive the original email message.
            |
            */

    use VerifiesEmails;

    public function show(Request $request)
    {
        $role = auth()->user()->roles->first()->name;
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('auth.verify', compact('role'));
    }

    public function showVerificationForm()
    {
        abort(404);
    }

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    protected function verified()
    {
        $verified = 1;
        $success = 1;

        return redirect($this->redirectTo . '?verified=' . $verified . '&success=' . $success);
    }

    public function resend(Request $request)
    {

        $validate = $request->validate([
            'email-update' => 'required|email',
        ]);

        $user = auth()->user();
        $newEmail = $request->input('email-update');
        $user->email = $newEmail;
        $user->save();

        if ($request->user()->hasVerifiedEmail()) {
            return new JsonResponse([
                'message' => 'Email already verified.',
            ], 400);
        }

        $request->user()->sendEmailVerificationNotification();
        return $this->successToastResponse(__('common.email_verification_sent'));
    }
}
