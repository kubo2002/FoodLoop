<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    // index() – zobrazí všetky kategórie ponúk.
    // Toto je úvodná obrazovka sekcie Ponuky – používateľ si vyberie kategóriu.
    public function index()
    {
        $categories = Category::all();
        return view('offers.index', compact('categories'));
    }

    // byCategory() – AJAX endpoint.
    // Na základe ID kategórie vráti HTML partial s ponukami danej kategórie.
    // Používam to na dynamické načítanie ponúk bez reloadu stránky.
    public function byCategory($id)
    {
        $offers = Offer::where('category_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('offers._list', compact('offers'));
    }

    // create() – formulár pre vytvorenie novej ponuky.
    // Môže to urobiť iba donor, takže najprv kontrolujem rolu.
    public function create()
    {
        $this->authorizeDonor(); // overí, či má používateľ rolu donor
        $categories = Category::all(); // potrebujem ich do selectu

        return view('offers.create', compact('categories'));
    }

    // store() – ukladá novú ponuku do databázy.
    public function store(Request $request)
    {
        $this->authorizeDonor();

        // Validácia vstupov z formulára.
        // Kontrolujem povinné polia, typu inputov a veľkosť obrázka.
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string'],
            'expiration_date' => ['nullable', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        // Ak používateľ nahral fotku, uložím ju na disk (do storage/public/offers).
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('offers', 'public');
        }

        // Každá ponuka musí mať autora – aktuálne prihlásený donor.
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'available'; // nová ponuka je vždy dostupná

        // Uložím ponuku do databázy.
        Offer::create($validated);

        return redirect()->route('offers.index')
            ->with('success', 'Ponuka bola úspešne pridaná.');
    }

    // show() – zobrazí detail jednej ponuky.
    public function show($id)
    {
        $offer = Offer::findOrFail($id);
        return view('offers.show', compact('offer'));
    }

    // edit() – formulár pre úpravu existujúcej ponuky.
    // Donor môže upravovať len svoje vlastné ponuky.
    public function edit($id)
    {
        $this->authorizeDonor();

        $offer = Offer::findOrFail($id);

        // Ak nie som autor tejto ponuky → blokujem úpravu.
        if ($offer->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();

        return view('offers.edit', compact('offer', 'categories'));
    }

    // update() – uloží zmeny na ponuke
    public function update(Request $request, $id)
    {
        $this->authorizeDonor();

        $offer = Offer::findOrFail($id);

        // opäť kontrolujem, či som autor
        if ($offer->user_id !== Auth::id()) {
            abort(403);
        }

        // Validácia vstupov rovnako ako pri store()
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string'],
            'expiration_date' => ['nullable', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        // Ak bola nahraná nová fotka, nahradím starú
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('offers', 'public');
        }

        // Aktualizácia v databáze
        $offer->update($validated);

        return redirect()->route('offers.show', $offer->id)
            ->with('success', 'Ponuka bola úspešne upravená.');
    }

    // destroy() – zmaže ponuku.
    // Donor môže vymazať iba svoju vlastnú ponuku.
    public function destroy($id)
    {
        $this->authorizeDonor();

        $offer = Offer::findOrFail($id);

        if ($offer->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        // zmažeme fotku ak existuje
        if ($offer->image) {
            Storage::disk('public')->delete($offer->image);
        }

        $offer->delete();

        return response()->json(['success' => true]);
    }

    // authorizeDonor() – malá pomocná metóda.
    // Umožní vstup iba používateľom s rolou donor.
    private function authorizeDonor()
    {
        if (Auth::user()->role !== 'donor') {
            abort(403); // recipient nesmie pridávať ani upravovať ponuky
        }
    }
}
