@extends('layouts.app')

@section('content')
<div class="page">
    <div class="cluster mb-3 justify-between">
        <h3>Moje ponuky</h3>
        <a href="{{ route('offers.create') }}" class="btn btn-primary">
            + Vytvoriť novú ponuku
        </a>
    </div>

    @if(session('success'))
        <div class="notice notice-success">{{ session('success') }}</div>
    @endif

    @if($offers->isEmpty())
        <div class="notice notice-info">Zatiaľ ste nevytvorili žiadne ponuky.</div>
    @else
        <div class="panel pad">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Názov</th>
                        <th>Stav</th>
                        <th>Platnosť do</th>
                        <th>Vytvorené</th>
                        <th class="text-right">Akcie</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offers as $offer)
                        <tr>
                            <td>{{ $offer->id }}</td>
                            <td>
                                {{ $offer->title }}
                                @if($offer->is_expired)
                                    <span class="tag tag-danger">Expirované</span>
                                @endif
                                @if($offer->hasPickedUpReservation())
                                    <span class="tag tag-success">Vyzdvihnuté</span>
                                @endif
                            </td>
                            <td>{{ $offer->status }}</td>
                            <td>{{ optional($offer->expiration_date)->format('Y-m-d') ?? $offer->expiration_date }}</td>
                            <td>{{ $offer->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-right">
                                <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-outline btn-sm">Detail</a>
                                <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-secondary btn-sm">Upraviť</a>
                                <button class="btn btn-danger btn-sm delete-offer" data-id="{{ $offer->id }}">Vymazať</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
