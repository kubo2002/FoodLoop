@extends('layouts.app')
@section('content')
    <div class="profile-wrapper">
        <div class="profile-card">
            <div class="photo-wrapper">
                <img src="{{ auth()->user()->photo
                ? asset('storage/' . auth()->user()->photo)
                : 'https://via.placeholder.com/150' }}"
                     class="photo" alt="Profile photo">
            </div>
            <h2 class="name">{{ auth()->user()->name }}</h2>
            <p class="email">{{ auth()->user()->email }}</p>
            <p class="role">{{ __('messages.role') }}: {{ auth()->user()->role }}</p>
            <div class="buttons">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="btn btn-danger">
                    {{ __('messages.logout') }}
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                    @csrf
                </form>
                <a href="{{ route('edit-profile') }}" class="btn btn-primary">
                    {{ __('messages.editProfile') }}
                </a>
            </div>
        </div>
    </div>
@endsection
