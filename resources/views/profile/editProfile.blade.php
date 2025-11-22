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
                <div class="bg-secondary rounded"
                     style="width: 200px; height: 200px; display: flex; align-items: center; justify-content: center;">
                    <span class="text-white-50">200x200</span>
                </div>

            </div>

            <!-- Formular pre zmeny mena -->
            <div class="mb-3">
                <label class="form-label"> <strong>{{ __('messages.name') }}</strong></label>
                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ auth()->user()->name }}"
                >

                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Formular pre zmeny emailu -->
            <div class="mb-3">
                <label class="form-label"><strong>Email</strong></label>
                <input
                    type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ auth()->user()->email }}"
                >


                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>



            <!-- Vyber role donor/recipient -->
            <div class="mb-3">
                <label class="form-label"><strong>{{ __('messages.role') }}</strong></label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="" disabled selected>{{ auth()->user()-> role }}</option>
                    <option value="donor">{{ __('messages.donor') }}</option>
                    <option value="recipient">{{ __('messages.recipient') }}</option>
                </select>

                <!-- Blade direktiva kontroluje ci existuje po odolsani validaacna chyba pre rolu  -->
                @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <a href="#" class="btn btn-primary mt-3">{{ __('messages.editProfile') }}</a>


        </div>
    </div>
@endsection
