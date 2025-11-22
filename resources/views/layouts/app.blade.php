<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodLoop</title>
    {{-- link na bootstrap ikonky pouzivatelskeho profilu --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet"/>

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

</head>
<body class="bg-light">

    {{-- zaciatok navbaru  --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container-fluid">

            {{-- Brand / Logo --}}
            <a class="navbar-brand fw-bold" href="#">
                FoodLoop
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Obsah navbaru --}}
            <div class="collapse navbar-collapse" id="navbarContent">

                {{-- Ľavá strana – linky --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">{{ __('messages.home')}}</a>
                    </li>

                    {{-- sem potom doplníme ďalšie (Ponuky, Kontakt...) --}}
                </ul>

                <ul class="navbar-nav ms-auto">
                    {{-- Ikona profilu --}}
                    <li class="nav-item d-flex align-items-center me-3">
                        <a href="{{ route('profile') }}" class="nav-link">
                            <i class="bi bi-person-circle fs-5"></i>
                        </a>
                    </li>

                    {{-- Prepínače jazykov --}}
                    @php $lang = app()->getLocale(); @endphp
                    <li class="nav-item d-flex align-items-center">
                        <a href="{{ route('lang.switch', 'sk') }}"
                           class="btn mx-1 {{ $lang == 'sk' ? 'btn-primary' : 'btn-outline-primary' }}">
                            SK
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}"
                           class="btn mx-1 {{ $lang == 'en' ? 'btn-primary' : 'btn-outline-primary' }}">
                            EN
                        </a>
                    </li>
                </ul>
            </div>
        </div>


    </nav>

<main>
    @yield('content')
</main>

</body>
</html>
