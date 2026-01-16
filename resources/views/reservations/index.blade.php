
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Moje rezervácie</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($reservations->isEmpty())
            <p class="text-muted">Zatiaľ nemáš žiadne rezervácie.</p>
        @else
            <div class="list-group">
                @foreach($reservations as $r)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1">{{ $r->offer?->title ?? 'Ponuka už neexistuje' }}</h5>
                                @if($r->offer)
                                    <div class="text-muted" style="font-size:.9rem">
                                        Lokalita: <strong>{{ $r->offer->location }}</strong><br>
                                        Expirácia: <strong>{{ $r->offer->expiration_date }}</strong><br>
                                        Stav: <strong>{{ $r->status }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>

                        {{-- U: zmena statusu --}}
                        <form class="mt-3" method="POST" action="{{ route('reservations.update', $r->id) }}">
                            @csrf
                            @method('PATCH')

                            <div class="d-flex gap-2 align-items-center">
                                <select name="status" class="form-select form-select-sm" style="max-width: 200px;">
                                    <option value="reserved" {{ $r->status === 'reserved' ? 'selected' : '' }}>Rezervované</option>
                                    <option value="picked_up" {{ $r->status === 'picked_up' ? 'selected' : '' }}>Vyzdvihnuté</option>
                                </select>
                                <button class="btn btn-sm btn-success" type="submit">Uložiť</button>
                            </div>
                        </form>

                        {{-- D: zmazanie --}}
                        <form class="mt-2" method="POST" action="{{ route('reservations.destroy', $r->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit"
                                    onclick="return confirm('Naozaj odstrániť rezerváciu?')">
                                Odstrániť
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
