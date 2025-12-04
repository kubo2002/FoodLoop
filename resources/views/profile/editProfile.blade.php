{{-- Dedenie z hlavného layoutu --}}
@extends('layouts.app')

{{-- Obsah stránky pre editáciu profilu --}}
@section('content')

    {{-- Wrapper pre centrovanie --}}
    <div class="profile-wrapper">
        <div class="profile-card">

            {{-- Tlačidlo späť na profil --}}
            <a href="{{route('profile')}}" class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> {{ __('messages.myProfile') }}
            </a>

            {{-- Zobrazenie aktuálnej profilovej fotky --}}
            <div class="photo-wrapper" id="profile-photo-wrapper">
                <img src="{{ auth()->user()->photo
                ? asset('storage/' . auth()->user()->photo)
                : 'https://via.placeholder.com/150' }}"
                     class="photo" alt="Profile photo" id="profile-photo">
            </div>

            {{-- Tlačidlo pre zmazanie fotky - zobrazí sa len ak existuje fotka --}}
            @if(auth()->user()->photo)
                <form method="POST" action="{{ route('profile.photo.delete') }}" id="delete-photo-form" class="mt-2">
                    @csrf
                    @method('DELETE') {{-- Laravel metóda pre DELETE HTTP request --}}
                    <button type="button" onclick="confirmDeletePhoto()" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i> {{ __('messages.deletePhoto') }}
                    </button>
                </form>
            @endif

            {{-- Nadpis stránky --}}
            <h2 class="name">{{ __('messages.editProfile') }}</h2>

            {{-- Formulár pre aktualizáciu profilu --}}
            {{-- enctype="multipart/form-data" je potrebné pre upload súborov --}}
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-3">
                @csrf {{-- CSRF ochrana --}}

                {{-- Input pre upload novej profilovej fotky --}}
                <div class="mb-3 text-start">
                    <label class="form-label">{{ __('messages.profilePicture') }}</label>
                    <input type="file" name="photo" class="form-control">
                </div>

                {{-- Input pre meno --}}
                <div class="mb-3 text-start">
                    <label class="form-label">{{ __('messages.name') }}</label>
                    {{-- old() vráti predošlú hodnotu pri validačnej chybe, inak aktuálne meno --}}
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', auth()->user()->name) }}">
                </div>

                {{-- Input pre email --}}
                <div class="mb-3 text-start">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', auth()->user()->email) }}">
                </div>

                {{-- Select pre výber role (donor/recipient) --}}
                <div class="mb-3 text-start">
                    <label class="form-label">{{ __('messages.role') }}</label>
                    {{-- @error pridá Bootstrap triedu 'is-invalid' ak je validačná chyba --}}
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        {{--
                            Dynamické nastavenie selected atribútu:
                            - old('role') vráti hodnotu ak bola validačná chyba
                            - auth()->user()->role je aktuálna rola z databázy
                            - selected sa pridá len k option, ktorá sa zhoduje s aktuálnou rolou
                        --}}
                        <option value="donor" {{ old('role', auth()->user()->role) == 'donor' ? 'selected' : '' }}>
                            {{ __('messages.donor') }}
                        </option>
                        <option value="recipient" {{ old('role', auth()->user()->role) == 'recipient' ? 'selected' : '' }}>
                            {{ __('messages.recipient') }}
                        </option>
                    </select>

                    {{-- Zobrazenie validačnej chyby pre role, ak existuje --}}
                    @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit tlačidlo --}}
                <button class="btn btn-success w-100 mt-2">{{ __('messages.saveChanges')}}</button>
            </form>

        </div>
    </div>

@endsection
