@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Nadpis stránky --}}
        <h2 class="mb-4">Pridať novú ponuku</h2>

        <div class="card shadow-sm p-4">

            {{--
                FORMULÁR PRE VYTVORENIE PONUKY
                - route('offers.store') smeruje do OfferController@store
                - enctype="multipart/form-data" je povinný pri uploadovaní obrazkov
            --}}
            <form action="{{ route('offers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf {{-- Laravelov CSRF token, nutný pri POST požiadavkách --}}

                {{-- Názov ponuky --}}
                <div class="mb-3">
                    <label class="form-label">Názov</label>

                    {{--
                        Bootstrap .is-invalid sa pridá v prípade validačnej chyby.
                        old('title') zachová hodnotu pri refreshi (neúspešnej validácii).
                    --}}
                    <input type="text"
                           name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}"
                           placeholder="Napr. Čerstvé rožky">

                    {{-- Chybová hláška z validácie servera --}}
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Popis ponuky --}}
                <div class="mb-3">
                    <label class="form-label">Popis</label>

                    <textarea name="description"
                              rows="4"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Popíš detailnejšie, čo ponúkaš">{{ old('description') }}</textarea>

                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Lokalita --}}
                <div class="mb-3">
                    <label class="form-label">Lokalita</label>

                    <input type="text"
                           name="location"
                           class="form-control @error('location') is-invalid @enderror"
                           value="{{ old('location') }}"
                           placeholder="Napr. Martin – Stráne">

                    @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dátum expirácie --}}
                <div class="mb-3">
                    <label class="form-label">Dátum expirácie</label>

                    {{--
                        Input typu "date"
                        Laravel akceptuje dátum iba vo formáte YYYY-MM-DD.
                        old('expiration_date') zachová pôvodnú hodnotu po validačnej chybe.
                    --}}
                    <input type="date"
                           name="expiration_date"
                           class="form-control @error('expiration_date') is-invalid @enderror"
                           value="{{ old('expiration_date') }}">

                    @error('expiration_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Výber kategórie --}}
                <div class="mb-3">
                    <label class="form-label">Kategória</label>

                    {{--
                        Select s kategoriami načítanými z databázy.
                        @selected porovná aktuálnu hodnotu old() so skutočnou voľbou.
                    --}}
                    <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror">

                        <option value="">-- vyber kategóriu --</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload obrázka --}}
                <div class="mb-3">
                    <label class="form-label">Fotka (voliteľné)</label>

                    {{--
                        Typ file sa používa na upload obrázkov.
                        @error zobrazí chybu, napr. ak je obrázok príliš veľký alebo zlý formát.
                    --}}
                    <input type="file"
                           name="image"
                           class="form-control @error('image') is-invalid @enderror">

                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tlačidlá (späť a odoslať) --}}
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('offers.index') }}" class="btn btn-secondary">
                        Späť
                    </a>

                    <button type="submit" class="btn btn-success">
                        Pridať ponuku
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
