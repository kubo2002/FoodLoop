<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodLoop</title>
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
    <meta name="app-translations" content='@json(__('messages'))'>
    <script src="{{ asset('js/register.js') }}" defer></script>
    <script src="{{ asset('js/reservation.js') }}" defer></script>
    <script src="{{ asset('js/login.js') }}" defer></script>
    <script src="{{ asset('js/offer.js') }}" defer></script>
    <script src="{{ asset('js/categories.js') }}" defer></script>
</head>
<body>
<header class="header">
    <div class="wrap header-inner">
        <a class="brand" href="{{ route('home') }}">FoodLoop</a>
        <nav class="nav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}">{{ __('messages.home') }}</a>
            <a href="{{ route('offers.index') }}" class="{{ request()->routeIs('offers.*') ? 'is-active' : '' }}">{{ __('messages.offers') }}</a>
            @if(auth()->check() && auth()->user()->role === 'recipient')
                <a href="{{ route('reservations.index') }}" class="{{ request()->routeIs('reservations.*') ? 'is-active' : '' }}">Moje rezervácie</a>
            @endif
            @if(auth()->check() && auth()->user()->role === 'donor')
                <a href="{{ route('offers.mine') }}" class="{{ request()->routeIs('offers.mine') ? 'is-active' : '' }}">Moje ponuky</a>
            @endif
            <a href="{{ route('profile') }}">Profil</a>
            @php $lang = app()->getLocale(); @endphp
            <div class="lang-switch">
                <a href="{{ route('lang.switch', 'sk') }}" class="lang-btn {{ $lang == 'sk' ? 'is-active' : '' }}" aria-label="Switch to Slovak">SK</a>
                <a href="{{ route('lang.switch', 'en') }}" class="lang-btn {{ $lang == 'en' ? 'is-active' : '' }}" aria-label="Switch to English">EN</a>
            </div>
        </nav>
    </div>
</header>
<main>
    @yield('content')
</main>
<script src="{{ asset('js/profile.js') }}" defer></script>
</body>
</html>
