<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Category;
use App\Http\Requests\OfferStoreRequest;
use App\Http\Requests\OfferUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{

    public function myOffers()
    {
        $this->authorizeDonor();

        $offers = Offer::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('offers.my_offers', compact('offers'));
    }


    public function index()
    {
        $categories = Category::all();
        return view('offers.index', compact('categories'));
    }

    public function byCategory($id)
    {
        $offers = Offer::where('category_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('offers._list', compact('offers'));
    }

    public function create()
    {
        $this->authorizeDonor();
        $categories = Category::all();

        return view('offers.create', compact('categories'));
    }

    public function store(OfferStoreRequest $request)
    {
        $this->authorizeDonor();

        // Server-side validácia vstupov cez Form Request
        $validated = $request->validated();

        // Upload obrázka (ak bol pridaný)
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('offers', 'public');
        }

        // Každá ponuka musí mať autora (donora)
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'available';

        // Uloženie novej ponuky do databázy
        Offer::create($validated);

        return redirect()->route('offers.index')
            ->with('success', 'Ponuka bola úspešne pridaná.');
    }

    public function show($id)
    {
        $offer = Offer::findOrFail($id);
        return view('offers.show', compact('offer'));
    }

    public function edit($id)
    {
        $this->authorizeDonor();

        $offer = Offer::findOrFail($id);

        // Overenie, či je aktuálny používateľ autorom ponuky
        if ($offer->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();

        return view('offers.edit', compact('offer', 'categories'));
    }

    public function update(OfferUpdateRequest $request, $id)
    {
        $this->authorizeDonor();

        $offer = Offer::findOrFail($id);

        // Používateľ musí byť autorom ponuky
        if ($offer->user_id !== Auth::id()) {
            abort(403);
        }

        // Validácia vstupov cez Form Request
        $validated = $request->validated();

        // Nahratie novej fotky (prepíše starú)
        if ($request->hasFile('image')) {
            // Zmazanie starej fotky, ak existuje
            if (!empty($offer->image)) {
                Storage::disk('public')->delete($offer->image);
            }
            $validated['image'] = $request->file('image')->store('offers', 'public');
        }

        // Uloženie zmien
        $offer->update($validated);

        return redirect()->route('offers.show', $offer->id)
            ->with('success', 'Ponuka bola úspešne upravená.');
    }

    public function destroy($id)
    {
        $this->authorizeDonor();

        $offer = Offer::findOrFail($id);

        // Bezpečnostná kontrola – autor musí byť ten istý
        if ($offer->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        // Zmazanie obrázka zo storage
        if ($offer->image) {
            Storage::disk('public')->delete($offer->image);
        }

        // Zmazanie ponuky z DB
        $offer->delete();

        return response()->json(['success' => true]);
    }

    private function authorizeDonor()
    {
        if (Auth::user()->role !== 'donor') {
            abort(403);
        }
    }
}
