<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Základná stránka po prihlásení používateľa.
     *
     * Vracia Blade „home“, ktorému odovzdávam aktuálne
     * prihláseného používateľa. Ten viem získať cez Auth::user().
     */
    public function index()
    {
        return view('home', ['user' => Auth::user()]);
    }

    /**
     * Zobrazenie profilu používateľa
     *
     * Táto metóda iba vráti view s údajmi profilu.
     */
    public function profile()
    {
        return view('profile.index');
    }

    /**
     * Zobrazenie formulára na editáciu profilu
     */
    public function editProfile()
    {
        return view('profile.editProfile');
    }

    /**
     * UPDATE profilu používateľa
     * ---------------------------
     * Táto metóda je zodpovedná za aktualizáciu:
     *  - mena
     *  - emailu
     *  - role (donor/recipient)
     *  - profilovej fotky (ak bola pridaná)
     *
     * Používam server-side validáciu cez $request->validate(),
     * aby boli údaje skontrolované aj na backend úrovni.
     */
    public function updateProfile(Request $request) {

        // Získanie aktuálne prihláseného používateľa
        $user = auth()->user();

        // Validácia údajov – Laravel automaticky vyhodí chybu pri neplatných údajoch
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // email musí byť unikátny okrem aktuálneho usera
            'role'  => 'required|in:donor,recipient',
        ]);

        // Ak používateľ nahráva novú fotku → uložíme ju do storage
        if ($request->hasFile('photo')) {

            /**
             * Upload logika:
             * - uložím súbor do storage/app/public/profile_photos/
             * - disk 'public' je prepojený so storage:link
             * - cesta (path) sa uloží do DB
             */
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

    /**
     * DELETE – Zmazanie profilovej fotky
     * -----------------------------------
     * Toto je kompletná DELETE operácia na úrovni používateľského profilu.
     *
     * Proces:
     * 1. Získam prihláseného používateľa
     * 2. Ak má fotku, vymažem fyzický súbor zo storage
     * 3. Nastavím stĺpec photo v databáze na NULL
     * 4. Presmerujem späť s flash správou
     */
    public function deletePhoto()
    {
        // Aktuálny používateľ
        $user = auth()->user();

        // Ak má uloženú fotku, tak ju fyzicky odstránim
        if ($user->photo) {

            /**
             * Storage::disk('public') → smeruje na storage/app/public/
             * delete() → odstráni fyzický obrázok
             */
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
