<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DashboardController extends BaseController
{
    public function index()
    {
        $user = auth()->user()->load(['roles.permissions', 'permissions']);
        $students = User::all();
        return view('dashboard.pages.dashboard', compact('user', 'students'));
    }

    // public function sendEmail(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'message' => 'required|string',
    //     ]);

    //     $email = $request->email;
    //     $message = $request->message;

    //     Mail::to($email)->send(new SendEmail($message));

    //     return $this->successToastResponse('Email sent successfully');
    // }
}
