<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    // zoznam kategórii / zoznam ponuk
    public function index()
    {
        $categories = Category::all();
        return view('offers.index', compact('categories'));
    }

    // AJAX: ponuky podľa kategórie
    public function byCategory($id)
    {
        $offers = Offer::where('category_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('offers._list', compact('offers'));
    }

    // form na pridanie ponuky
    public function create()
    {
        $this->authorizeDonor();
        $categories = Category::all();

        return view('offers.create', compact('categories'));
    }

    // uloženie ponuky do DB
    public function store(Request $request)
    {
        $this->authorizeDonor();

        // TODO: validácia & uloženie
    }

    // detail ponuky
    public function show($id)
    {
        $offer = Offer::findOrFail($id);
        return view('offers.show', compact('offer'));
    }

    // form na upravu ponuky
    public function edit($id)
    {
        $this->authorizeDonor();

        $offer = Offer::findOrFail($id);

        if ($offer->user_id !== Auth::id()) {
            abort(403); // donor môže upraviť iba svoje
        }

        $categories = Category::all();

        return view('offers.edit', compact('offer', 'categories'));
    }

    // uloženie zmien
    public function update(Request $request, $id)
    {
        $this->authorizeDonor();

        // TODO: validácia & update
    }

    // DELETE – zmazanie ponuky
    public function destroy($id)
    {
        $this->authorizeDonor();

        $offer = Offer::findOrFail($id);

        if ($offer->user_id !== Auth::id()) {
            abort(403);
        }

        // TODO: delete & AJAX response
    }

    // pomocná funkcia
    private function authorizeDonor()
    {
        if (Auth::user()->role !== 'donor') {
            abort(403); // recipient nesmie pridávať ani upravovať
        }
    }
}
