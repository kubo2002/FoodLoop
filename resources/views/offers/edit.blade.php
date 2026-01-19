@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h2 class="mb-4">{{ __('messages.edit_offer') }}</h2>

        <div class="card shadow-sm p-4">

            <form action="{{ route('offers.update', $offer->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">{{ __('messages.title') }}</label>

                    <input type="text"
                           name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $offer->title) }}">

                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('messages.description') }}</label>

                    <textarea name="description"
                              rows="4"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $offer->description) }}</textarea>

                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


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


                <div class="mb-3">
                    <label class="form-label">{{ __('messages.expiration_date') }}</label>


                    <input type="date"
                           name="expiration_date"
                           class="form-control @error('expiration_date') is-invalid @enderror"
                           value="{{ old('expiration_date', $offer->expiration_date) }}">

                    @error('expiration_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label class="form-label">{{ __('messages.category') }}</label>


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


                <div class="mb-3">
                    <label class="form-label">{{ __('messages.current_photo') }}</label><br>

                    @if($offer->image)

                        <img src="{{ asset('storage/' . $offer->image) }}" class="h-120 rounded-8">
                    @else

                        <p class="text-muted">{{ __('messages.no_photo') }}</p>
                    @endif
                </div>


                <div class="mb-3">
                    <label class="form-label">{{ __('messages.new_photo') }}</label>


                    <input type="file"
                           name="image"
                           class="form-control @error('image') is-invalid @enderror">

                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4 d-flex justify-content-between">

                    <a href="{{ route('offers.index') }}" class="btn btn-secondary">
                        {{ __('messages.back') }}
                    </a>


                    <button type="submit" class="btn btn-warning">
                        {{ __('messages.save_changes') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
