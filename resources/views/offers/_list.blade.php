@if($offers->isEmpty())
    <p class="muted">{{ __('messages.categories_title') }}</p>
@else
    <div class="grid-3">
        @foreach($offers as $offer)
            <div id="offer-{{ $offer->id }}" class="panel hover offer-card">
                @if($offer->image)
                    <img src="{{ asset('storage/' . $offer->image) }}" alt="Offer image" class="img-cover h-200">
                @else
                    <div class="offer-card-placeholder"></div>
                @endif
                <div class="pad">
                    <h5 class="offer-title">{{ $offer->title }}</h5>
                    <p class="offer-meta">
                        {{ Str::limit($offer->description, 100) }}
                    </p>
                    <p class="offer-meta">
                        {{ __('messages.location') }} <strong>{{ $offer->location }}</strong><br>
                        {{ __('messages.expiration') }} <strong>{{ $offer->expiration_date }}</strong>
                        @if($offer->is_expired)
                            <strong class="tag tag-danger">Expirované</strong>
                        @endif
                    </p>
                    <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-primary btn-sm btn-custom">
                        {{ __('messages.detail') }}
                    </a>
                    @if(auth()->id() === $offer->user_id)
                        <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-secondary btn-sm btn-custom">
                            {{ __('messages.edit') }}
                        </a>
                        <button type="button" class="btn btn-danger btn-sm delete-offer btn-custom" data-id="{{ $offer->id }}">
                            {{ __('messages.delete') }}
                        </button>
                    @endif
                    @if(auth()->user()->role === 'recipient' && $offer->status === 'available')
                        @if(!$offer->is_expired)
                            <button type="button" class="btn btn-primary btn-sm btn-custom" onclick="addToCart(this, {{ $offer->id }})">
                                Rezervovať
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary btn-sm btn-custom" disabled title="Ponuka je expirovaná">
                                Rezervovať
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif
