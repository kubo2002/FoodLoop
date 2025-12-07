@extends('layouts.app')
@section('content')

    <div class="container mt-5">

        <div class="card shadow-sm p-4" style="max-width: 600px; margin: auto;">
            <h2 class="text-center mb-4">
                {{ __('messages.welcome') }} {{ auth()->user()->name }} !
            </h2>

            <p class="text-center">
                {{ __('messages.welcomeScreenText') }}
                <strong>{{ auth()->user()->role }}</strong>.
            </p>

            {{-- Tlačidlo na stránku ponúk --}}
            <div class="text-center mt-4">
                <a href="{{ route('offers.index') }}" class="btn btn-primary btn-lg">
                    {{ __('messages.goToOffers')}}
                </a>
            </div>

        </div>

    </div>
@endsection
