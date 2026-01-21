
@extends('layouts.app')

@section('content')

<div class="auth-page">
    <div class="panel pad auth-card">
        <h3 class="text-center mb-3">{{ __('messages.login') }}</h3>

        @if (!empty($login_failed))
            <div class="notice notice-error mb-3" role="alert">
                {{ $login_failed }}
            </div>
        @endif

        <form id="login-form" method="POST" action="{{ route('login') }}" class="stack">
            @csrf

            <div class="field">
                <label class="label" for="login-email">Email</label>
                <input type="email" name="email" id="login-email" class="input form-control @error('email') is-invalid @enderror" value="{{ $old_email ?? old('email') }}">
                <div class="error-message error" id="login-error-email"></div>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label class="label" for="login-password">{{ __('messages.password') }}</label>
                <input type="password" name="password" id="login-password" class="input form-control @error('password') is-invalid @enderror">
                <div class="error-message error" id="login-error-password"></div>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('messages.login') }}</button>

            <div class="text-center">
                <a href="{{ route('register.show') }}">{{ __('messages.noAccount') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
