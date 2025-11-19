<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodLoop</title>
    {{-- link na bootstrap ikonky pouzivatelskeho profilu --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    {{-- zaciatok navbaru  --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">

            {{-- LAVA STRANA - profil icon --}}
            <a class="d-flex align-items-center" href="#">
                <i class="bi bi-person-circle fs-3"></i>
            </a>

            {{-- STRED - logo foodloop (mozno pojde prec) --}}
            <span class="mx-auto fw-bold" style="color: #2E7D32;">
            FoodLoop
            </span>

            {{-- PRAVA STRANA – Profil --}}
            <div class="navbar-brand d-flex">
                <a href="{{ route('home') }}" class="nav-link">Domov</a>

                @if(Auth::check())
                    <a href="{{ route('offers.index') }}" class="nav-link">Ponuky</a>

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-link nav-link" style="text-decoration:none;">
                            Odhlásiť sa
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </nav>
<main>
    @yield('content')
</main>

</body>
</html>
