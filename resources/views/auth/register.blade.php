@extends('layouts.app')

@section('content')

<div class="auth-page">
    <div class="panel pad auth-card">
        <h3 class="text-center mb-3">{{ __('messages.register') }}</h3>

        @if (!empty($register_failed))
            <div class="notice notice-error mb-3">{{ $register_failed }}</div>
        @endif

        @if ($errors->any())
            <div class="notice notice-error mb-3">{{ $errors->first() }}</div>
        @endif

        <form id="register-form" method="POST" action="{{ route('register') }}" class="stack">
            @csrf

            <div class="field">
                <label class="label" for="name">{{ __('messages.name') }}</label>
                <input type="text" name="name" id="name" class="input form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                <div class="error-message error" id="error-name"></div>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label class="label" for="email">Email</label>
                <input type="email" name="email" id="email" class="input form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                <div class="error-message error" id="error-email"></div>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label class="label" for="password">{{ __('messages.password') }}</label>
                <input type="password" name="password" id="password" class="input form-control @error('password') is-invalid @enderror">
                <div class="error-message error" id="error-password"></div>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label class="label" for="password_confirmation">{{ __('messages.confirmPassword') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="input form-control">
                <div class="error-message error" id="error-confirm"></div>
            </div>

            <div class="field">
                <label class="label" for="role">{{ __('messages.role') }}</label>
                <select name="role" id="role" class="select form-control @error('role') is-invalid @enderror" required>
                    <option value="" disabled selected>{{ __('messages.selectRole') }}</option>
                    <option value="donor">{{ __('messages.donor') }}</option>
                    <option value="recipient">{{ __('messages.recipient') }}</option>
                </select>
                @error('role')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('messages.register') }}</button>

            <div class="text-center">
                <a href="{{ route('login.show') }}">{{ __('messages.alreadyHaveAccount') }}</a>
            </div>
        </form>
    </div>
</div>

@endsection
