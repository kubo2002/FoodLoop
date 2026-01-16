<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private function authorizeRecipient(): void
    {
        if (auth()->user()->role !== 'recipient') {
            abort(403);
        }
    }

    // zoznam
    public function index()
    {
        $this->authorizeRecipient();

        $reservations = Reservation::with('offer')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    // vytvorenie
    public function store(Offer $offer)
    {
        $this->authorizeRecipient();

        if ($offer->status !== 'available') {
            return response()->json(['ok' => false, 'message' => 'Ponuka nie je dostupná.'], 409);
        }

        Reservation::updateOrCreate(
            ['user_id' => auth()->id(), 'offer_id' => $offer->id],
            ['status' => 'reserved']
        );

        $offer->status = 'reserved';
        $offer->save();

        return response()->json(['ok' => true]);
    }

    // update statusu
    public function update(Request $request, Reservation $reservation)
    {
        $this->authorizeRecipient();

        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:cart,reserved,picked_up,cancelled'],
        ]);

        $reservation->status = $validated['status'];
        $reservation->save();


        if ($reservation->offer && $validated['status'] === 'reserved') {
            $reservation->offer->status = 'reserved';
            $reservation->offer->save();
        }

        // kvoli AJAX
        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'status' => $reservation->status,
            ]);
        }

        return redirect()->route('reservations.index')->with('success', 'Rezervácia bola aktualizovaná.');
    }

    // delete (zrušiť rezerváciu)
    public function destroy(Request $request, Reservation $reservation)
    {
        $this->authorizeRecipient();

        if ($reservation->user_id !== auth()->id()) abort(403);

        $offer = $reservation->offer;

        $reservation->delete();

        if ($offer && $offer->status === 'reserved') {
            $offer->status = 'available';
            $offer->save();
        }

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Rezervácia bola odstránená.');
    }
}

