@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Tlačidlo späť na zoznam kategórií --}}
        <a href="{{ route('offers.index') }}" class="btn btn-secondary mb-3">
            {{ __('messages.back_categories') }}
        </a>

        <div class="card shadow-sm p-4">

            {{--OBRÁZOK PONUKY--}}
            @if($offer->image)
                <img src="{{ asset('storage/' . $offer->image) }}"
                     class="img-fluid rounded mb-4"
                     style="max-height: 350px; object-fit: cover;">
            @else
                <div class="bg-light mb-4"
                     style="height: 250px; border-radius: 8px;"></div>
            @endif

            @php
                $isExpired = $offer->expiration_date && strtotime($offer->expiration_date) < strtotime(date('Y-m-d'));
            @endphp
            {{-- Názov ponuky --}}
            <h2 class="mb-3">{{ $offer->title }}</h2>

            {{-- Popis ponuky --}}
            <p class="text-muted" style="font-size: 1.1rem;">
                {{ $offer->description }}
            </p>

            <hr>

            {{--INFO SEKCIA PONUKY--}}
            <div class="mt-3" style="font-size: 1rem;">
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
                    <strong class="{{ $isExpired ? 'text-danger' : '' }}">Expirované</strong>
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

            {{--Tlačidlá na úpravu a zmazanie ponuky--}}
            @if(auth()->id() === $offer->user_id)
                <div class="mt-3 d-flex gap-2">

                    {{-- Tlačidlo úpravy --}}
                    <a href="{{ route('offers.edit', $offer->id) }}"
                       class="btn btn-warning">
                        Upraviť
                    </a>

                    {{--Tlačidlo DELETE pre AJAX mazanie.--}}
                    <button
                        type="button"
                        class="btn btn-danger delete-offer"
                        data-id="{{ $offer->id }}">
                        Vymazať
                    </button>

                </div>
            @endif

        </div>
    </div>
@endsection
