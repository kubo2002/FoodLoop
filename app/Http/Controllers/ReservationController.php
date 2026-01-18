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

        // Nemožno rezervovať vlastnú ponuku
        if ($offer->user_id === auth()->id()) {
            return response()->json(['ok' => false, 'message' => 'Nemôžeš rezervovať vlastnú ponuku.'], 403);
        }

        // Skontroluj expiráciu (ponuka po dátume expirácie je nedostupná)
        if ($offer->expiration_date && $offer->expiration_date->lt(now()->startOfDay())) {
            return response()->json(['ok' => false, 'message' => 'Ponuka je expirovaná.'], 409);
        }

        // Ponuka musí byť dostupná
        if ($offer->status !== 'available') {
            return response()->json(['ok' => false, 'message' => 'Ponuka nie je dostupná.'], 409);
        }

        // Zisti, či už mám aktívnu rezerváciu tejto ponuky
        $existing = Reservation::where('user_id', auth()->id())
            ->where('offer_id', $offer->id)
            ->whereIn('status', ['reserved', 'picked_up'])
            ->first();
        if ($existing) {
            return response()->json(['ok' => false, 'message' => 'Túto ponuku už máš rezervovanú.'], 409);
        }

        // Vytvor alebo aktualizuj rezerváciu na "reserved"
        Reservation::updateOrCreate(
            ['user_id' => auth()->id(), 'offer_id' => $offer->id],
            ['status' => 'reserved']
        );

        // Uzamkni ponuku pre ostatných
        $offer->status = 'reserved';
        $offer->save();

        return response()->json(['ok' => true, 'message' => 'Ponuka bola rezervovaná.']);
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

