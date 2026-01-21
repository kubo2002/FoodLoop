
@extends('layouts.app')

@section('content')
    <div class="page py-4">
        <h2 class="mb-3">Moje rezervácie</h2>

        @if($reservations->isEmpty())
            <p class="muted">Zatiaľ nemáš žiadne rezervácie.</p>
        @else
            <div class="stack">
                @foreach($reservations as $r)
                    <div class="panel pad" id="reservation-{{ $r->id }}">
                        <h5>{{ $r->offer?->title }}</h5>
                        <small class="muted">Stav: {{ $r->status }}</small>

                        <div class="mt-3 cluster">
                            <select class="select max-w-200" id="status-{{ $r->id }}">
                                <option value="reserved" {{ $r->status === 'reserved' ? 'selected' : '' }}>Rezervované</option>
                                <option value="picked_up" {{ $r->status === 'picked_up' ? 'selected' : '' }}>Vyzdvihnuté</option>
                            </select>

                            <button class="btn btn-primary btn-sm" onclick="updateReservation({{ $r->id }})">Uložiť</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteReservation({{ $r->id }})">Odstrániť</button>

                            <small class="muted" id="msg-{{ $r->id }}"></small>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
