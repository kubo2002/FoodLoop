<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

    /**
     * DELETE operácia - Zmazanie profilovej fotky (CRUD kompletné)
     *
     * Táto metóda implementuje DELETE časť CRUD operácií:
     * C - Create (register, upload fotky)
     * R - Read (zobrazenie profilu)
     * U - Update (updateProfile metóda)
     * D - Delete (táto metóda) ✓
     *
     * Proces zmazania:
     * 1. Získa aktuálne prihláseného používateľa cez auth()->user()
     * 2. Skontroluje, či má používateľ nahranutu fotku (if $user->photo)
     * 3. Vymaže fyzický súbor zo storage/app/public/profile_photos/
     * 4. Nastaví photo stĺpec v databáze na null
     * 5. Presmeruje späť na editáciu profilu s flash správou
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePhoto()
    {
        // Získanie aktuálne prihláseného používateľa z session
        $user = auth()->user();

        // Kontrola, či používateľ má nahranutu profilovú fotku
        // Ak photo je null alebo prázdny string, toto sa preskočí
        if ($user->photo) {
            // Storage facade - Laravel systém pre prácu so súbormi
            // disk('public') = storage/app/public/
            // delete() vymaže fyzický súbor (napr. profile_photos/abc123.jpg)
            Storage::disk('public')->delete($user->photo);

            // Aktualizácia databázy - nastavenie photo stĺpca na NULL
            // SQL: UPDATE users SET photo = NULL WHERE id = $user->id
            $user->update(['photo' => null]);
        }

        // Redirect späť na edit-profile stránku
        // with('success', ...) pridá flash správu do session (zobrazí sa raz)
        return redirect()->route('edit-profile')
            ->with('success', 'Profile photo deleted successfully.');
    }
}
