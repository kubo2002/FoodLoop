@extends('layouts.app')

@section('content')
    <div class="profile-wrapper">
        <div class="profile-card">
            <a href="{{route('profile')}}" class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> {{ __('messages.myProfile') }}
            </a>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="photo-wrapper" id="profile-photo-wrapper">
                <img src="{{ auth()->user()->photo
                ? asset('storage/' . auth()->user()->photo)
                : 'https://via.placeholder.com/150' }}"
                     class="photo" alt="Profile photo" id="profile-photo">
            </div>
            @if(auth()->user()->photo)
                <form method="POST" action="{{ route('profile.photo.delete') }}" id="delete-photo-form" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDeletePhoto()" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i> {{ __('messages.deletePhoto') }}
                    </button>
                </form>
            @endif
            <h2 class="name">{{ __('messages.editProfile') }}</h2>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-3">
                @csrf
                <div class="mb-3 text-start">
                    <label class="form-label">{{ __('messages.profilePicture') }}</label>
                    <input type="file" name="photo" class="form-control">
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label">{{ __('messages.name') }}</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', auth()->user()->name) }}">
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', auth()->user()->email) }}">
                </div>
                <button class="btn btn-success w-100 mt-2">{{ __('messages.saveChanges')}}</button>
            </form>
        </div>
    </div>
@endsection
