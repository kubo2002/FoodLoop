
@if($offers->isEmpty())
    <p class="text-muted">{{ __('messages.categories_title') }}</p>
@else
    <div class="row">
        @foreach($offers as $offer)
            @php
                $isExpired = $offer->expiration_date && strtotime($offer->expiration_date) < strtotime(date('Y-m-d'));
            @endphp
            {{--
                Wrapper pre jednu ponuku.--}}
            <div class="col-md-4 mb-3" id="offer-{{ $offer->id }}">
                <div class="card h-100 offer-card">

                    {{--Obrázok ponuky:--}}
                    @if($offer->image)
                        <img src="{{ asset('storage/' . $offer->image) }}"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">
                    @else
                        <div style="height:200px; background:#eee;"></div>
                    @endif

                    <div class="card-body">

                        {{-- Názov ponuky --}}
                        <h5 class="card-title offer-title">{{ $offer->title }}</h5>


                        <p class="card-text text-muted" style="font-size: 0.9rem;">
                            {{ Str::limit($offer->description, 100) }}
                        </p>


                        <p class="offer-meta">
                            {{ __('messages.location') }} <strong>{{ $offer->location }}</strong><br>
                            {{ __('messages.expiration') }} <strong>{{ $offer->expiration_date }}</strong>
                            <strong class="{{ $isExpired ? 'text-danger' : '' }}">Expirované</strong>
                        </p>


                        {{-- Tlačidlo pre detail ponuky --}}
                        <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-primary btn-sm btn-custom">
                            {{ __('messages.detail') }}
                        </a>


                        @if(auth()->id() === $offer->user_id)

                            {{-- Tlačidlo na úpravu ponuky --}}
                            <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-primary btn-sm btn-custom">
                                {{ __('messages.edit') }}
                            </a>

                            {{--DELETE tlačidlo pre AJAX mazanie.--}}
                            <button
                                type="button"
                                class="btn btn-danger btn-sm delete-offer btn-custom"
                                data-id="{{ $offer->id }}">
                                {{ __('messages.delete') }}
                            </button>

                        @endif

                        {{-- tlacidlo pre vlozenie ponuky do kosika --}}
                        @if(auth()->user()->role === 'recipient' && $offer->status === 'available')
                            @if(!$isExpired)
                                <button type="button"
                                        class="btn btn-success btn-sm btn-custom"
                                        onclick="addToCart(this, {{ $offer->id }})">
                                    Rezervovať
                                </button>
                            @elseif($isExpired)
                                <button type="button"
                                        class="btn btn-secondary btn-sm btn-custom"
                                        disabled
                                        title="Ponuka je expirovaná">
                                    Rezervovať
                                </button>
                            @else
                                <button type="button"
                                        class="btn btn-secondary btn-sm btn-custom"
                                        disabled
                                        title="Ponuka už bola rezervovaná">
                                    Rezervované
                                </button>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
