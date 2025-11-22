@extends('layouts.app')

@section('content')

    <div class="container py-4">


        <!-- Box s profilovou fotkou, zatial som style pouzil priamo tu v blade -->
        <div class="d-flex align-items-center gap-4">
            <!-- Šedý placeholder -->
            <div class="rounded bg-secondary"
                 style="width: 200px; height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden;">

                @if(auth()->user()->photo)
                    {{-- Ak existuje profilovka --}}
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}"
                         alt="Profile photo"
                         style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    {{-- Placeholder --}}
                    <span class="text-white-50">200x200</span>
                @endif

            </div>

            <!-- Text napravo -->
            <h1 class="m-0">{{ __('messages.myProfile') }}</h1>
        </div>

        <!-- Box s informaciami o pouzivatelovi-->
        <div class="card p-4">
            <p><strong>{{ __('messages.name') }}: </strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>{{ __('messages.role') }}: </strong> {{ auth()->user()->role }}</p>
            <!-- odhlasenie -->
            <a href="{{ route('logout') }}" class="btn btn-outline-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('messages.logout') }}</a>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                @csrf
            </form>
            <!-- editovanie profilu -->
            <a href="{{route('edit-profile')}}" class="btn btn-primary mt-3">{{ __('messages.editProfile') }}</a>
        </div>
    </div>
@endsection
