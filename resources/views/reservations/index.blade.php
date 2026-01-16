
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Moje rezervácie</h2>

        @if($reservations->isEmpty())
            <p class="text-muted">Zatiaľ nemáš žiadne rezervácie.</p>
        @else
            <div class="list-group">
                @foreach($reservations as $r)
                    <div class="list-group-item" id="reservation-{{ $r->id }}">
                        <h5>{{ $r->offer?->title }}</h5>
                        <small class="text-muted">Stav: {{ $r->status }}</small>

                        <div class="mt-3 d-flex gap-2">
                            <select class="form-select form-select-sm"
                                    id="status-{{ $r->id }}"
                                    style="max-width: 200px;">
                                <option value="reserved" {{ $r->status === 'reserved' ? 'selected' : '' }}>Rezervované</option>
                                <option value="picked_up" {{ $r->status === 'picked_up' ? 'selected' : '' }}>Vyzdvihnuté</option>
                            </select>

                            <button class="btn btn-sm btn-success"
                                    onclick="updateReservation({{ $r->id }})">
                                Uložiť
                            </button>

                            <button class="btn btn-sm btn-danger"
                                    onclick="deleteReservation({{ $r->id }})">
                                Odstrániť
                            </button>

                            <small class="text-muted ms-2" id="msg-{{ $r->id }}"></small>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
