@extends('layouts.app')
@section('content')

<div class="container mt-5">


    <div class="card shadow-sm p-4" style="max-width: 600px; margin: auto;">
        <h2 class="text-center mb-4">{{ __('messages.welcome') }}  {{ auth()->user()->name }} !</h2>

        <p class="text-center">
            {{ __('messages.welcomeScreenText') }}
            <strong>{{ auth()->user()->role }}</strong>.
        </p>
    </div>

</div>
@endsection
