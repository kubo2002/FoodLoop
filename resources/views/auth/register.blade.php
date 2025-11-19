<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">


<!-- Bootstrap layout -->
<div class="container mt-5 custom-space">
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="col-md-5">
            @php $lang = app()->getLocale(); @endphp

            <div class="d-flex justify-content-center mb-3">
                <a href="{{ route('lang.switch', 'sk') }}"
                   class="btn mx-2 {{ $lang == 'sk' ? 'btn-primary' : 'btn-outline-primary' }}">
                    SK
                </a>
                <a href="{{ route('lang.switch', 'en') }}"
                   class="btn mx-2 {{ $lang == 'en' ? 'btn-primary' : 'btn-outline-primary' }}">
                    EN
                </a>
            </div>


            <!-- Karta s registracnym formularom -->
            <div class="card shadow-sm" style="max-width: 400px; margin: auto;">
                <div class="card-body">

                    <h3 class="text-center mb-4">{{ __('messages.register') }}</h3>

                    <!-- Zaciatok formulara -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Pole Name -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.name') }}</label>
                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                            >

                            <!-- Blade direktiva kontroluje ci existuje po odolsani validacna chyba pre meno  -->
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pole Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                            >

                            <!-- Blade direktiva kontroluje ci existuje po odolsani validacna chyba pre email  -->
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pole Password -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.password') }}</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                            >

                            <!-- Blade direktiva kontroluje ci existuje po odolsani validacna chyba pre heslo  -->
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Potvrdzovacie tlacidlo -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.confirmPassword') }}</label>
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                            >
                        </div>

                        <!-- Vyber role donor/recipient -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.role') }}</label>
                            <select
                                name="role"
                                class="form-select @error('role') is-invalid @enderror"
                            >
                                <option value="">{{ __('messages.selectRole') }}</option>
                                <option value="donor">{{ __('messages.donor') }}</option>
                                <option value="recipient">{{ __('messages.recipient') }}</option>
                            </select>

                            <!-- Blade direktiva kontroluje ci existuje po odolsani validaacna chyba pre rolu  -->
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100">{{ __('messages.register') }}</button>



                        <div class="text-center mt-3">
                            <a href="{{ route('login.show') }}">{{ __('messages.alreadyHaveAccount') }}</a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
