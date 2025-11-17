<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Bootstrap layout -->
<div class="container mt-5">

    <div class="position-absolute top-0 end-0 p-3">
        <a href="{{ route('lang.switch', 'sk') }}" class="btn btn-outline-primary btn-sm">SK</a>
        <a href="{{ route('lang.switch', 'en') }}" class="btn btn-outline-secondary btn-sm">EN</a>
    </div>

    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="col-md-5">

            <!-- Karta s prihlasovacim formularom -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <h3 class="text-center mb-4">{{ __('messages.login') }}</h3>

                    <!-- Zaciatok prihlasovacieho formulara -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Pole email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                            >
                            <!-- Blade direktiva kontroluje ci existuje po odolsani validacna chyba pre email  -->
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pole password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                            >
                            <!-- Blade direktiva kontroluje ci existuje po odolsani validacna chyba pre password  -->
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary w-100">Login</button>

                        <div class="text-center mt-3">
                            <a href="{{ route('register.show') }}">Registrácia</a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>

