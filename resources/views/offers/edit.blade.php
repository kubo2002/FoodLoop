@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Nadpis formulára – využívam preklad z messages.php --}}
        <h2 class="mb-4">{{ __('messages.edit_offer') }}</h2>

        <div class="card shadow-sm p-4">

            {{--
                FORMULÁR NA ÚPRAVU PONUKY
                - route('offers.update') smeruje do OfferController@update
                - method="POST" + @method('PUT') = PUT požiadavka (Laravel takto rieši PUT)
                - enctype je potrebné kvôli uploadu obrázka
            --}}
            <form action="{{ route('offers.update', $offer->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Názov ponuky --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.title') }}</label>

                    {{--
                        value = old(...) slúži na zachovanie hodnoty pri validačnej chybe,
                        druhý parameter $offer->title je pôvodná hodnota z DB.
                    --}}
                    <input type="text"
                           name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $offer->title) }}">

                    {{-- Vypíše chybu z validácie, ak existuje --}}
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Popis ponuky --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.description') }}</label>

                    <textarea name="description"
                              rows="4"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $offer->description) }}</textarea>

                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Lokalita ponuky --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.location') }}</label>

                    <input type="text"
                           name="location"
                           class="form-control @error('location') is-invalid @enderror"
                           value="{{ old('location', $offer->location) }}">

                    @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Expirácia ponuky --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.expiration_date') }}</label>

                    {{--
                        Input typu "date" chce hodnotu vo formáte YYYY-MM-DD.
                        Laravel ju z DB vracia v správnom formáte, takže to funguje.
                    --}}
                    <input type="date"
                           name="expiration_date"
                           class="form-control @error('expiration_date') is-invalid @enderror"
                           value="{{ old('expiration_date', $offer->expiration_date) }}">

                    @error('expiration_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Výber kategórie --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.category') }}</label>

                    {{--
                        Vypíšem všetky kategórie,
                        a ak sa zhodujú s offer->category_id alebo old(), označím ich ako selected.
                    --}}
                    <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror">

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id', $offer->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Aktuálna fotka --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.current_photo') }}</label><br>

                    @if($offer->image)
                        {{-- Ak má ponuka fotku, zobrazím ju --}}
                        <img src="{{ asset('storage/' . $offer->image) }}"
                             style="height:120px; border-radius:8px;">
                    @else
                        {{-- Ak fotka neexistuje, zobrazím text z prekladu --}}
                        <p class="text-muted">{{ __('messages.no_photo') }}</p>
                    @endif
                </div>

                {{-- Upload novej fotky --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.new_photo') }}</label>

                    {{--
                        Nahratie novej fotky je voliteľné.
                        Ak používateľ nič nevyberie, ponechá sa pôvodná.
                    --}}
                    <input type="file"
                           name="image"
                           class="form-control @error('image') is-invalid @enderror">

                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Ovládacie tlačidlá --}}
                <div class="mt-4 d-flex justify-content-between">
                    {{-- Späť na zoznam ponúk --}}
                    <a href="{{ route('offers.index') }}" class="btn btn-secondary">
                        {{ __('messages.back') }}
                    </a>

                    {{-- Uložiť zmeny --}}
                    <button type="submit" class="btn btn-warning">
                        {{ __('messages.save_changes') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
