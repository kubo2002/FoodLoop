@extends('layouts.app')
@section('content')

<div class="container mt-5">
    @php $lang = app()->getLocale(); @endphp

        <!-- Prepinace jazykov-->
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
    <div class="card shadow-sm p-4" style="max-width: 600px; margin: auto;">
        <h2 class="text-center mb-4">{{ __('messages.welcome') }}  {{ auth()->user()->name }} !</h2>

        <p class="text-center">
            {{ __('messages.welcomeScreenText') }}
            <strong>{{ auth()->user()->role }}</strong>.
        </p>
    </div>

</div>
@endsection
