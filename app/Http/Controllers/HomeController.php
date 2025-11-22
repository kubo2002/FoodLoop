<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        return view('home', ['user' => Auth::user()]);
    }

    public function profile()
    {
        return view('profile.index');
    }

    public function editProfile()
    {
        return view('profile.editProfile');
    }
}
