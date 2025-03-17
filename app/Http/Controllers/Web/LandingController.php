<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use Illuminate\Http\Request;

class LandingController extends BaseController
{
    public function index()
    {
        if (auth()->check()) {
            $role = auth()->user()->roles->first()->name;
            $email = auth()->user()->email;
            return view('web.welcome', compact('role', 'email'));
        }
        return view('web.welcome');
    }

    public function submitNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:news_letters,email',
        ]);

        NewsLetter::create($request->all());

        return $this->successToastResponse('Email added to newsletter');
    }
}
