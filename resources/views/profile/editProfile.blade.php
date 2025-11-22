@extends('layouts.app')

@section('content')

    <div class="container py-4">
        <a href="{{route('profile')}}" class="btn btn-primary mt-3">
            <i class="bi bi-arrow-left"> {{ __('messages.myProfile') }} </i>
        </a>

        <!-- Box s informaciami o pouzivatelovi-->
        <div class="card p-4">
            <h1 class="m-0">{{ __('messages.editProfile') }}</h1>

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



            </div>

            <!-- Formular pre zmeny mena -->
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.profilePicture') }}</label>
                    <input type="file" name="photo" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.name') }}</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', auth()->user()->name) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', auth()->user()->email) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('messages.role') }}</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="" disabled selected>{{ auth()->user()->role }}</option>
                        <option value="donor">{{ __('messages.donor') }}</option>
                        <option value="recipient">{{ __('messages.recipient') }}</option>
                    </select>

                    <!-- Blade direktiva kontroluje ci existuje po odolsani validaacna chyba pre rolu  -->
                    @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary">{{ __('messages.saveChanges')}}</button>
            </form>
        </div>
    </div>
@endsection
