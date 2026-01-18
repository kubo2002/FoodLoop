@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Moje ponuky</h3>
        <a href="{{ route('offers.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Vytvoriť novú ponuku
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($offers->isEmpty())
        <div class="alert alert-info">Zatiaľ ste nevytvorili žiadne ponuky.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Názov</th>
                        <th>Stav</th>
                        <th>Platnosť do</th>
                        <th>Vytvorené</th>
                        <th class="text-end">Akcie</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offers as $offer)
                        <tr>
                            <td>{{ $offer->id }}</td>
                            <td>
                                {{ $offer->title }}
                                @if($offer->is_expired)
                                    <span class="badge bg-danger ms-1">Expirované</span>
                                @endif
                                @if($offer->hasPickedUpReservation())
                                    <span class="badge bg-success ms-1">Vyzdvihnuté</span>
                                @endif
                            </td>
                            <td>{{ $offer->status }}</td>
                            <td>{{ optional($offer->expiration_date)->format('Y-m-d') ?? $offer->expiration_date }}</td>
                            <td>{{ $offer->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-outline-danger btn-sm delete-offer" data-id="{{ $offer->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
