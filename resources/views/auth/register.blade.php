@extends('layouts.app')

@section('content')

<!-- Bootstrap layout -->
<div class="container mt-5 custom-space">
    <div class="d-flex justify-content-center align-items-center bg-light">
        <div class="col-md-5">
            <!-- Karta s registracnym formularom -->
            <div class="card shadow-sm" style="max-width: 400px; margin: auto;">
                <div class="card-body">

                    <h3 class="text-center mb-4">{{ __('messages.register') }}</h3>

                    @if (!empty($register_failed))
                        <div class="alert alert-danger">
                            {{ $register_failed }}
                        </div>
                    @endif
                    <!-- Zaciatok formulara -->
                    <form id="register-form" method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Pole Name -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.name') }}</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                            >
                            <div class="text-danger small error-message" id="error-name"></div>

                        </div>

                        <!-- Pole Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                            >

                            <div class="text-danger small error-message" id="error-email"></div>
                        </div>

                        <!-- Pole Password -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.password') }}</label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                            >

                            <div class="text-danger small error-message" id="error-password"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.confirmPassword') }}</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                            >

                            <div class="text-danger small error-message" id="error-confirm"></div>
                        </div>

                        <!-- Vyber role donor/recipient -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.role') }}</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="" disabled selected>{{ __('messages.selectRole') }}</option>
                                <option value="donor">{{ __('messages.donor') }}</option>
                                <option value="recipient">{{ __('messages.recipient') }}</option>
                            </select>

                            <!-- Blade direktiva kontroluje ci existuje po odolsani validaacna chyba pre rolu  -->
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Potvrdzovacie tlacidlo -->
                        <button type="submit" class="btn btn-success w-100">{{ __('messages.register') }}</button>


                        <div class="text-center mt-3">
                            <a href="{{ route('login.show') }}">{{ __('messages.alreadyHaveAccount') }}</a>
                        </div>

                    </form>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
