<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $role = auth()->user()->roles->first()->name;
            return view('web.welcome', compact('role'));
        }
        return view('web.welcome');
    }
}
