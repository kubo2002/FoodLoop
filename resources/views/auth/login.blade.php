
@extends('layouts.app')

@section('content')

<!-- Bootstrap layout -->
<div class="container mt-5 custom-space">
    <div class="d-flex justify-content-center align-items-center bg-light">
        <div class="col-md-5">

            <!-- Karta s prihlasovacim formularom -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <h3 class="text-center mb-4">{{ __('messages.login') }}</h3>

                    <!-- Zobrazenie chyby prihlasovania -->
                    @if (!empty($login_failed))
                        <div class="alert alert-danger" role="alert">
                            {{ $login_failed }}
                        </div>
                    @endif

                    <!-- Zaciatok prihlasovacieho formulara -->
                    <form id="login-form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Pole email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="login-email"
                                class="form-control @error('email') is-invalid @enderror"
                            >

                            <div class="text-danger small error-message" id="login-error-email"></div>
                        </div>

                        <!-- Pole password -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.password') }}</label>
                            <input
                                type="password"
                                name="password"
                                id="login-password"
                                class="form-control @error('password') is-invalid @enderror"
                            >

                            <div class="text-danger small error-message" id="login-error-password"></div>
                        </div>

                        <button class="btn btn-primary w-100">{{ __('messages.login') }}</button>

                        <div class="text-center mt-3">
                            <a href="{{ route('register.show') }}">{{ __('messages.noAccount') }}</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
