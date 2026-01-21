@extends('layouts.app')
@section('content')
    <div class="page">
        <div class="panel pad mb-4 text-center">
            <h2 class="mb-2">{{ __('messages.welcome') }} {{ auth()->user()->name }} !</h2>
            <p class="muted">{{ __('messages.welcomeScreenText') }} <strong>{{ auth()->user()->role }}</strong>.</p>
        </div>
        <div class="grid-3 mb-4">
            <div class="panel pad text-center">
                <h3 class="mb-2">Ponuky</h3>
                <p class="muted mb-3">Prechádzaj aktuálne dostupné ponuky podľa kategórií.</p>
                <a href="{{ route('offers.index') }}" class="btn btn-primary">Zobraziť ponuky</a>
            </div>
            <div class="panel pad text-center">
                <h3 class="mb-2">Moje ponuky</h3>
                <p class="muted mb-3">Pre donorov: spravuj svoje ponuky a sleduj stav.</p>
                <a href="{{ route('offers.mine') }}" class="btn btn-secondary">Moje ponuky</a>
            </div>
            <div class="panel pad text-center">
                <h3 class="mb-2">Profil</h3>
                <p class="muted mb-3">Nastavenia účtu a profilová fotka.</p>
                <a href="{{ route('profile') }}" class="btn btn-secondary">Profil</a>
            </div>
        </div>
        <div class="panel pad">
            <h3 class="mb-3">Ako to funguje</h3>
            <div class="grid-3">
                <div class="panel pad">
                    <h4 class="mb-1">1. Pridaj</h4>
                    <p class="muted">Donor vytvorí ponuku jedlom, ktoré nechce vyhodiť.</p>
                </div>
                <div class="panel pad">
                    <h4 class="mb-1">2. Rezervuj</h4>
                    <p class="muted">Recipient si ponuku rezervuje cez aplikáciu.</p>
                </div>
                <div class="panel pad">
                    <h4 class="mb-1">3. Vyzdvihni</h4>
                    <p class="muted">Rezervované jedlo si vyzdvihne v dohodnutom čase.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
