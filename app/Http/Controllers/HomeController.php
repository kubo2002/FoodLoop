<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    public function updateProfile(Request $request) {
        $user = auth()->user();

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:donor,recipient',
        ]);

        // Ak existuje fotka → uložíme ju do validated
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile_photos', 'public');
            $validated['photo'] = $path;
        }

        // Update všetkého naraz
        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');

    }
}
