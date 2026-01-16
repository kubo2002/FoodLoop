<!DOCTYPE html>
{{-- Nastavenie jazyka stránky podľa aktuálnej lokalizácie --}}
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Responsive meta tag pre mobilné zariadenia --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodLoop</title>

    {{-- Načítanie Bootstrap CSS frameworku z CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Načítanie Bootstrap ikon --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet"/>
    {{-- Vlastný CSS súbor pre profil --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    {{-- Vlastný CSS súbor pre prepínač jazykov --}}
    <link rel="stylesheet" href="{{ asset('css/language-switcher.css') }}">
    {{-- Vlastný CSS súbor pre dizajn karty jednotlivej ponuky --}}
    <link rel="stylesheet" href="{{ asset('css/offer.css') }}">
    {{-- Vlastný JS súbor pre Client-side validaciu registračného formulára --}}
    <script src="{{ asset('js/register.js') }}"></script>
    {{-- Vlastný JS súbor pre pridanie ponuky do kosika  --}}
    <script src="{{ asset('js/cart.js') }}"></script>
    {{-- Vlastný JS súbor pre Client-side validaciu login formulára --}}
    <script src="{{ asset('js/login.js') }}"></script>

    {{-- Pridanie prekladov do js --}}
    <script>
        window.translations = @json(__('messages'));
    </script>

    {{-- Skripty pre AJAX volania nad ponukami --}}
    <script src="{{ asset('js/offer.js') }}"></script>
    <script src="{{ asset('js/categories.js') }}"></script>

    {{-- Vite pre kompiláciu CSS/JS (momentálne zakázané) --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
{{-- Svetlo-šedé pozadie celej stránky --}}
<body class="bg-light">

    {{-- Navigačný bar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        {{-- Container pre navbar obsah --}}
        <div class="container-fluid">

            {{-- Logo / Názov aplikácie --}}
            <a class="navbar-brand fw-bold" href="#">
                FoodLoop
            </a>

            {{-- Hamburger menu tlačidlo pre mobilné zariadenia --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Obsah navbaru (kolapsovatený na mobiloch) --}}
            <div class="collapse navbar-collapse" id="navbarContent">

                {{-- Ľavá strana navbaru - navigačné linky --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        {{-- Link na domovskú stránku s prekladom --}}
                        <a class="nav-link active" href="{{ route('home') }}">{{ __('messages.home')}}</a>
                    </li>

                    {{-- Link na zoznam rezervovanych položiek ak som v roli recipient --}}
                    @if(auth()->check() && auth()->user()->role === 'recipient')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('reservations.index') }}">Moje rezervácie</a>
                        </li>
                    @endif
                </ul>

                {{-- Pravá strana navbaru --}}
                <ul class="navbar-nav ms-auto">
                    {{-- Ikona profilu --}}
                    <li class="nav-item d-flex align-items-center me-3">
                        <a href="{{ route('profile') }}" class="nav-link">
                            {{-- Bootstrap ikona pre profil --}}
                            <i class="bi bi-person-circle fs-5"></i>
                        </a>
                    </li>

                    {{-- Prepínač jazykov (SK/EN) --}}
                    @php $lang = app()->getLocale(); @endphp {{-- Získanie aktuálneho jazyka --}}
                    <li class="nav-item d-flex align-items-center">
                        {{-- Slovenčina - aktívne tlačidlo ak je SK jazyk --}}
                        <a href="{{ route('lang.switch', 'sk') }}"
                           class="btn mx-1 language-btn {{ $lang == 'sk' ? 'btn-primary' : 'btn-outline-primary' }}"
                           data-lang="sk">
                            SK
                        </a>
                        {{-- Angličtina - aktívne tlačidlo ak je EN jazyk --}}
                        <a href="{{ route('lang.switch', 'en') }}"
                           class="btn mx-1 language-btn {{ $lang == 'en' ? 'btn-primary' : 'btn-outline-primary' }}"
                           data-lang="en">
                            EN
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

{{-- Hlavný obsah stránky - sem sa vkladá obsah z podstránok --}}
<main>
    @yield('content') {{-- Blade direktíva pre vloženie obsahu z @section('content') --}}
</main>

{{-- Načítanie externého JavaScript súboru pre profil --}}
{{-- Externé JS súbory = lepšia organizácia kódu, možnosť cachovania prehliadačom --}}
<script src="{{ asset('js/profile.js') }}"></script>

</body>
</html>
