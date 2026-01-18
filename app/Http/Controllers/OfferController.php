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
    /**
     * Donor – Moje ponuky
     * --------------------
     * Zobrazí všetky ponuky vytvorené aktuálne prihláseným donorom.
     */
    public function myOffers()
    {
        $this->authorizeDonor();

        $offers = Offer::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('offers.my_offers', compact('offers'));
    }

    /**
     * index()
     * -------
     * Zobrazí úvodnú stránku sekcie Ponuky.
     * Na tejto stránke si používateľ vyberá kategóriu.
     * Ponuky sa nezobrazujú hneď – načítavajú sa dynamicky cez AJAX.
     */
    public function index()
    {
        $categories = Category::all();
        return view('offers.index', compact('categories'));
    }

    /**
     * byCategory()
     * ------------
     * AJAX endpoint.
     * Na základe ID kategórie vráti HTML partial s ponukami.
     * Používam ho pri kliknutí na kategóriu → stránka sa nerefreshuje.
     */
    public function byCategory($id)
    {
        $offers = Offer::where('category_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('offers._list', compact('offers'));
    }

    /**
     * create()
     * --------
     * Zobrazí formulár pre vytvorenie novej ponuky.
     * Prístup má len používateľ s rolou "donor".
     */
    public function create()
    {
        $this->authorizeDonor();
        $categories = Category::all();

        return view('offers.create', compact('categories'));
    }

    /**
     * store()
     * -------
     * Spracovanie vytvorenia novej ponuky:
     * - validácia
     * - uloženie obrázka
     * - uloženie ponuky do DB
     * - priradenie používateľa ako autora
     */
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

    /**
     * show()
     * ------
     * Detail jednej ponuky.
     * Zobrazuje všetky informácie vrátane autora, obrázka a kategórie.
     */
    public function show($id)
    {
        $offer = Offer::findOrFail($id);
        return view('offers.show', compact('offer'));
    }

    /**
     * edit()
     * ------
     * Formulár na editáciu ponuky.
     * Upraviť môže iba používateľ, ktorý ponuku vytvoril.
     */
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

    /**
     * update()
     * --------
     * Uloží zmeny existujúcej ponuky.
     * Prebieha rovnaká validácia ako pri create().
     */
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

    /**
     * destroy()
     * ---------
     * Mazanie ponuky.
     * Volá sa cez AJAX → vraciam JSON odpoveď.
     * Pred zmazaním:
     *   - overím rolu donora
     *   - overím, či je používateľ autorom
     *   - zmažem obrázok zo storage (ak existuje)
     */
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

    /**
     * authorizeDonor()
     * ----------------
     * Pomocná metóda na kontrolu prístupových práv.
     * Donor môže:
     *  - pridávať ponuky
     *  - upravovať ponuky
     *  - mazať ponuky
     * Recipient NESMIE.
     */
    private function authorizeDonor()
    {
        if (Auth::user()->role !== 'donor') {
            abort(403);
        }
    }
}
