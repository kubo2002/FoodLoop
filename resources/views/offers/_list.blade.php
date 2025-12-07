{{--
    Ak v tejto kategórii nie sú žiadne ponuky,
    zobrazím iba jednoduchý text.
--}}
@if($offers->isEmpty())
    <p class="text-muted">{{ __('messages.categories_title') }}</p>


@else
    {{--
        Ak ponuky existujú, vypíšem ich do bootstrapového gridu.
        Každá ponuka je jedna kolónka (col-md-4).
    --}}
    <div class="row">

        @foreach($offers as $offer)

            {{--
                Wrapper pre jednu ponuku.
                ID offer-{id} používam kvôli AJAX mazaniu,
                aby som vedel tento konkrétny prvok odstrániť z DOM-u.
            --}}
            <div class="col-md-4 mb-3" id="offer-{{ $offer->id }}">
                <div class="card h-100 offer-card">

                    {{--
                        Obrázok ponuky:
                        - ak existuje, zobrazím ho
                        - ak nie, zobrazím sivé placeholder pozadie
                    --}}
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

                        {{--
                            Popis skrátený na 100 znakov.
                            Funkcia Str::limit() pochádza z Laravel helperov.
                        --}}
                        <p class="card-text text-muted" style="font-size: 0.9rem;">
                            {{ Str::limit($offer->description, 100) }}
                        </p>

                        {{--
                            Základné detaily: lokalita a expirácia.
                            Využívam preklady z messages.php.
                        --}}
                        <p class="offer-meta">
                            {{ __('messages.location') }} <strong>{{ $offer->location }}</strong><br>
                            {{ __('messages.expiration') }} <strong>{{ $offer->expiration_date }}</strong>
                        </p>


                        {{-- Tlačidlo pre detail ponuky --}}
                        <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-primary btn-sm btn-custom">
                            {{ __('messages.detail') }}
                        </a>


                        {{--
                            Donor môže upraviť alebo vymazať iba VLASTNÉ ponuky.
                            Preto kontrolujem, či autor ponuky = aktuálne prihlásený user.
                        --}}
                        @if(auth()->id() === $offer->user_id)

                            {{-- Tlačidlo na úpravu ponuky --}}
                            <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-primary btn-sm btn-custom">
                                {{ __('messages.edit') }}
                            </a>

                            {{--
                                DELETE tlačidlo pre AJAX mazanie.
                                - type="button" je kritické → aby sa neodosielal žiadny form
                                - data-id obsahuje ID ponuky
                                - .delete-offer používa JS (offers.js), ktorý vykoná AJAX delete
                            --}}
                            <button
                                type="button"
                                class="btn btn-danger btn-sm delete-offer btn-custom"
                                data-id="{{ $offer->id }}">
                                {{ __('messages.delete') }}
                            </button>

                            </a>


                        @endif
                    </div>

                </div>
            </div>
        @endforeach

    </div>
@endif
