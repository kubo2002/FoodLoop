@extends('layouts.app')
@section('content')

<div class="container mt-5">

    <div class="card shadow-sm p-4" style="max-width: 600px; margin: auto;">
        <h2 class="text-center mb-4">{{ __('messages.welcome') }}</h2>

        <p class="text-center">
            {{ auth()->user()->name }},
            you're successfully logged in as a
            <strong>{{ auth()->user()->role }}</strong>.
        </p>

        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('logout') }}"
               class="btn btn-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('messages.logout') }}
            </a>
        </div>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
            @csrf
        </form>
    </div>

</div>
@endsection
