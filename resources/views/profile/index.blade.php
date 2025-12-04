{{-- Dedenie z hlavného layoutu (app.blade.php) - získame navbar, CSS, atď. --}}
@extends('layouts.app')

{{-- Definícia obsahu, ktorý sa vloží do @yield('content') v app.blade.php --}}
@section('content')

    {{-- Wrapper pre centrovanie karty profilu --}}
    <div class="profile-wrapper">

        {{-- Hlavná karta profilu --}}
        <div class="profile-card">

            {{-- Kontajner pre profilovú fotku --}}
            <div class="photo-wrapper">
                {{-- Ternárny operátor: Ak existuje fotka, zobraz ju z storage, inak placeholder --}}
                <img src="{{ auth()->user()->photo
                ? asset('storage/' . auth()->user()->photo)
                : 'https://via.placeholder.com/150' }}"
                     class="photo" alt="Profile photo">
            </div>

            {{-- Zobrazenie mena používateľa --}}
            <h2 class="name">{{ auth()->user()->name }}</h2>

            {{-- Zobrazenie emailu používateľa --}}
            <p class="email">{{ auth()->user()->email }}</p>

            {{-- Zobrazenie role s prekladom cez __() helper --}}
            <p class="role">{{ __('messages.role') }}: {{ auth()->user()->role }}</p>

            {{-- Kontajner pre tlačidlá --}}
            <div class="buttons">
                {{-- Logout tlačidlo --}}
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="btn btn-danger">
                    {{-- Preložený text pre logout --}}
                    {{ __('messages.logout') }}
                </a>

                {{-- Skrytý formulár pre logout (POST request kvôli CSRF ochrane) --}}
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                    @csrf {{-- CSRF token pre zabezpečenie --}}
                </form>

                {{-- Tlačidlo pre editáciu profilu --}}
                <a href="{{ route('edit-profile') }}" class="btn btn-primary">
                    {{ __('messages.editProfile') }}
                </a>
            </div>

        </div>

    </div>

@endsection
