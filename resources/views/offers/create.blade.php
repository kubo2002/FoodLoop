@extends('layouts.app')

@section('content')
    <div class="page">
        <h2 class="mb-4">Pridať novú ponuku</h2>
        <div class="panel pad">
            <form action="{{ route('offers.store') }}" method="POST" enctype="multipart/form-data" class="stack">
                @csrf
                <div class="field">
                    <label class="label">Názov</label>
                    <input type="text" name="title" class="input @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Napr. Čerstvé rožky">
                    @error('title')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label class="label">Popis</label>
                    <textarea name="description" rows="4" class="textarea @error('description') is-invalid @enderror" placeholder="Popíš detailnejšie, čo ponúkaš">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label class="label">Lokalita</label>
                    <input type="text" name="location" class="input @error('location') is-invalid @enderror" value="{{ old('location') }}" placeholder="Napr. Martin – Stráne">
                    @error('location')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label class="label">Dátum expirácie</label>
                    <input type="date" name="expiration_date" class="input @error('expiration_date') is-invalid @enderror" value="{{ old('expiration_date') }}">
                    @error('expiration_date')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label class="label">Kategória</label>
                    <select name="category_id" class="select @error('category_id') is-invalid @enderror">
                        <option value="">-- vyber kategóriu --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label class="label">Fotka (voliteľné)</label>
                    <input type="file" name="image" class="input @error('image') is-invalid @enderror">
                    @error('image')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="cluster justify-between">
                    <a href="{{ route('offers.index') }}" class="btn btn-secondary">Späť</a>
                    <button type="submit" class="btn btn-primary">Pridať ponuku</button>
                </div>
            </form>
        </div>
    </div>
@endsection
