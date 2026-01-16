@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Nadpis stránky — preklad z messages.php --}}
        <h2 class="mb-4">{{ __('messages.categories_title') }}</h2>


        {{--GRID kategórií--}}
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-4 mb-3">
                    <div class="card category-card p-3 text-center shadow-sm"
                         data-category-id="{{ $category->id }}"
                         style="cursor:pointer; transition:0.2s;">

                        {{-- Názov kategórie --}}
                        <h5 class="m-0">{{ $category->name }}</h5>
                    </div>
                </div>
            @endforeach
        </div>


        {{--Tlačidlo pre pridanie ponuky--}}
        @if(auth()->user()->role === 'donor')
            <div class="text-end mb-3">
                <a href="{{ route('offers.create') }}" class="btn btn-success">
                    {{ __('messages.add_offer') }}
                </a>
            </div>
        @endif


        <hr>

        {{-- Nadpis pre sekciu s ponukami --}}
        <h3 class="mt-4 mb-3">{{ __('messages.offers_title') }}</h3>


        {{--WRAPPER PRE AJAX OBSAH--}}
        <div id="offers-wrapper" class="mt-3">
            {{-- Text, ktorý sa zobrazí predtým, než si používateľ vyberie kategóriu --}}
            <p class="text-muted">{{ __('messages.select_category') }}</p>
        </div>

    </div>
@endsection
