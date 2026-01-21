<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;

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

    //pomoc s AI pri upadte profilovej fotky
    public function updateProfile(UpdateProfileRequest $request) {

        // Získanie aktuálne prihláseného používateľa
        $user = auth()->user();

        // Validácia údajov – teraz cez Form Request triedu
        $validated = $request->validated();

        // Ak používateľ nahráva novú fotku → uložíme ju do storage
        if ($request->hasFile('photo')) {
            // Zmaž starú fotku, ak existuje
            if (!empty($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }


            $path = $request->file('photo')->store('profile_photos', 'public');

            // doplním foto do validovaných údajov
            $validated['photo'] = $path;
        }

        // Aktualizácia používateľa – mass assignment (fillable v User modeli)
        $user->update($validated);

        return redirect()
            ->route('profile')
            ->with('success', 'Profile updated successfully.');
    }

    //pomoc s AI
    public function deletePhoto()
    {
        // Aktuálny používateľ
        $user = auth()->user();

        // Ak má uloženú fotku, tak ju fyzicky odstránim
        if ($user->photo) {


            Storage::disk('public')->delete($user->photo);

            // Nastavím photo na null v databáze
            $user->update(['photo' => null]);
        }

        // Presmerovanie späť na editáciu profilu s úspešnou hláškou
        return redirect()
            ->route('edit-profile')
            ->with('success', 'Profile photo deleted successfully.');
    }
}
