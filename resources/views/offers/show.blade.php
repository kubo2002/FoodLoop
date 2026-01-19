@extends('layouts.app')

@section('content')
    <div class="page">
        <a href="{{ route('offers.index') }}" class="btn btn-secondary mb-3">
            {{ __('messages.back_categories') }}
        </a>
        <div class="panel pad">
            @if($offer->image)
                <img src="{{ asset('storage/' . $offer->image) }}" class="offer-detail-image mb-4" alt="Offer image">
            @else
                <div class="offer-detail-placeholder mb-4"></div>
            @endif
            <h2 class="mb-3">
                {{ $offer->title }}
                @if(auth()->id() === $offer->user_id)
                    @if($offer->is_expired)
                        <span class="tag tag-danger">Expirované</span>
                    @endif
                    @if($offer->hasPickedUpReservation())
                        <span class="tag tag-success">Vyzdvihnuté</span>
                    @endif
                @endif
            </h2>
            <p class="offer-description muted">
                {{ $offer->description }}
            </p>
            <hr>
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
                        <span class="tag tag-danger">Expirované</span>
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
            @if(auth()->id() === $offer->user_id)
                <div class="mt-3 cluster">
                    <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-secondary">Upraviť</a>
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
