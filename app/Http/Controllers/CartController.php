<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Reservation;

class CartController extends Controller
{
    public function index()
    {
        $items = Reservation::with('offer')
            ->where('user_id', auth()->id())
            ->where('status', 'CART')
            ->latest()
            ->get();

        return view('cart.index', compact('items'));
    }

    public function add(Offer $offer)
    {
        if (auth()->user()->role !== 'recipient') {
            abort(403, 'Only recipients can add offers to cart.');
        }

        if ($offer->status !== 'available') {
            return response()->json([
                'ok' => false,
                'message' => 'Ponuka nie je dostupná.'
            ], 409);
        }

        Reservation::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'offer_id' => $offer->id
            ],
            [
                'status' => 'CART'
            ]
        );

        return response()->json(['ok' => true]);
    }

    public function remove(Offer $offer)
    {
        Reservation::where('user_id', auth()->id())
            ->where('offer_id', $offer->id)
            ->where('status', 'CART')
            ->delete();

        return response()->json(['ok' => true]);
    }

    public function confirm()
    {
        $cartItems = Reservation::where('user_id', auth()->id())
            ->where('status', 'CART')
            ->get();

        foreach ($cartItems as $item) {
            $offer = Offer::find($item->offer_id);

            if (!$offer || $offer->status !== 'AVAILABLE') {
                continue; // alebo vráť chybu, podľa toho čo chceš
            }

            $item->status = 'RESERVED';
            $item->save();

            $offer->status = 'RESERVED';
            $offer->save();
        }

        return redirect()->route('cart.index')->with('success', 'Rezervácie potvrdené.');
    }
}
