@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Tlačidlo späť na zoznam kategórií --}}
        <a href="{{ route('offers.index') }}" class="btn btn-secondary mb-3">
            {{ __('messages.back_categories') }}
        </a>

        <div class="card shadow-sm p-4">

            {{-- OBRÁZOK PONUKY --}}
            @if($offer->image)
                <img src="{{ asset('storage/' . $offer->image) }}"
                     class="img-fluid rounded mb-4 offer-detail-image" alt="Offer image">
            @else
                <div class="bg-light mb-4 offer-detail-placeholder"></div>
            @endif

            {{-- Názov ponuky + stavové badge pre autora --}}
            <h2 class="mb-3">
                {{ $offer->title }}
                @if(auth()->id() === $offer->user_id)
                    @if($offer->is_expired)
                        <span class="badge bg-danger ms-2">Expirované</span>
                    @endif
                    @if($offer->hasPickedUpReservation())
                        <span class="badge bg-success ms-1">Vyzdvihnuté</span>
                    @endif
                @endif
            </h2>

            {{-- Popis ponuky --}}
            <p class="text-muted offer-description">
                {{ $offer->description }}
            </p>

            <hr>

            {{-- INFO SEKCIA PONUKY --}}
            <div class="mt-3 offer-info">
                <p>
                    <strong>{{ __('messages.category') }} :</strong>
                    {{ $offer->category->name }}
                </p>

                <p>
                    <strong>{{ __('messages.location') }}</strong>
                    {{ $offer->location }}
                </p>

                <p>
                    <strong>{{ __('messages.expiration') }}</strong>
                    {{ $offer->expiration_date ?? 'neuvedené' }}
                    @if($offer->is_expired)
                        <span class="text-danger">Expirované</span>
                    @endif
                </p>

                <p>
                    <strong>{{ __('messages.offer_author') }} :</strong>
                    {{ $offer->user->name }}
                </p>

                <p>
                    <strong>{{ __('messages.status') }} :</strong>
                    {{ __('messages.status_' . $offer->status) }}
                </p>
            </div>

            <hr>

            {{-- Tlačidlá na úpravu a zmazanie ponuky --}}
            @if(auth()->id() === $offer->user_id)
                <div class="mt-3 d-flex gap-2">

                    {{-- Tlačidlo úpravy --}}
                    <a href="{{ route('offers.edit', $offer->id) }}"
                       class="btn btn-warning">
                        Upraviť
                    </a>

                    {{-- DELETE – fallback formulár bez JS (pre jednoduchú obhajobu) --}}
                    <form action="{{ route('offers.destroy', $offer->id) }}" method="POST" onsubmit="return confirm('Naozaj chcete zmazať túto ponuku?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Vymazať</button>
                    </form>

                </div>
            @endif

        </div>
    </div>
@endsection
