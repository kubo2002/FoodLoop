@extends('layouts.app')

@section('content')
    <div class="page">
        <h2 class="mb-4">{{ __('messages.categories_title') }}</h2>
        <div class="grid-3">
            @foreach($categories as $category)
                <div class="panel pad hover category-card text-center cursor-pointer" data-category-id="{{ $category->id }}">
                    <h5>{{ $category->name }}</h5>
                </div>
            @endforeach
        </div>
        @if(auth()->user()->role === 'donor')
            <div class="text-right mb-3">
                <a href="{{ route('offers.create') }}" class="btn btn-primary">
                    {{ __('messages.add_offer') }}
                </a>
            </div>
        @endif
        <hr>
        <h3 class="mt-4 mb-3">{{ __('messages.offers_title') }}</h3>
        <div id="offers-wrapper" class="mt-3">
            <p class="muted">{{ __('messages.select_category') }}</p>
        </div>
    </div>
@endsection
