@extends('layouts.app')

@section('title')
    Gammes & Produits | Atelier 1830
@endsection


@section('content')
    <section id="gammes">
        <h1 class="title_section text-center mb-5"><div>Découvrez les gammes de notre atelier.</div></h1>
        <div class="container-fluid mb-4">
            <div class="row">

                @foreach ($gammes as $gamme)
                    <!-- Button trigger modal -->
                    <div class="col-lg-4 p-5 pb-0 col-md-4 mx-auto survol" data-bs-toggle="modal"
                        data-bs-target="#modalProductsGamme_{{ $gamme->id }}">
                        <a>
                            <img src="{{ asset('images/' . $gamme->image) }}" alt="titre_gammes" animate="true">
                            <h2 class="text-center">{{ $gamme->name }}</h2>
                        </a>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade show_products_gamme" id="modalProductsGamme_{{ $gamme->id }}" tabindex="-1"
                        aria-labelledby="modalProductsGammeLabel_{{ $gamme->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h1 class="modal-title" id="modalProductsGammeLabel_{{ $gamme->id }}">
                                        {{ $gamme->name }}</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="row ">

                                        @foreach ($gamme->products as $product)
                                            <div class="col-lg-3 m-2 mb-5 mx-auto">
                                                <div class="card mx-auto p-1">
                                                    <img src="{{ asset("images/$product->image") }}" class=" mx-auto mt-3"
                                                        alt="img_card_product" style="width:90%">
                                                    <h5 class="name_gamme_product">{{ $product->name }}</h5>
                                                    <div class="card-body">
                                                        <h5 class="card-title">Gamme : {{ $gamme->name }}</h5>
                                                        <hr>
                                                        <p class="card-text">{{ substr($product->desc, 0, 22) }} ...</p>
                                                        {{-- @php
                                                            $count_bad = 0;
                                                            $count_good = 0;
                                                            $count_verygood = 0;
                                                            $count = 0;
                                                        @endphp
                                                        @if (Auth::user() && Auth::user()->hasVotedForProduct($product->id))
                                                            @foreach ($product->satisfactions as $user)
                                                                @if ($user->pivot->note === 'bad')
                                                                    @php
                                                                        $count_bad++;
                                                                    @endphp
                                                                @endif
                                                                @if ($user->pivot->note === 'good')
                                                                    @php
                                                                        $count_good++;
                                                                    @endphp
                                                                @endif
                                                                @if ($user->pivot->note === 'verygood')
                                                                    @php
                                                                        $count_verygood++;
                                                                    @endphp
                                                                @endif
                                                                @php
                                                                    $count++;
                                                                @endphp
                                                            @endforeach
                                                            @if ($count)
                                                                <div class="stat_satis">
                                                                    <div class="contain_stat_satis">
                                                                        <p style="color: red">
                                                                            <b>{{ round(($count_bad * 100) / $count) }}%</b>
                                                                        </p>
                                                                        <img src="{{ asset('./images/logos/bad.png') }}"
                                                                            alt="" style="width: 1em">
                                                                    </div>
                                                                    <div class="contain_stat_satis">
                                                                        <p style="color: rgb(255, 213, 0)">
                                                                            <b>{{ round(($count_good * 100) / $count) }}%
                                                                            </b>
                                                                        </p>
                                                                        <img src="{{ asset('./images/logos/good.png') }}"
                                                                            alt="" style="width: 1em">
                                                                    </div>
                                                                    <div class="contain_stat_satis">
                                                                        <p style="color: green">
                                                                            <b>{{ round(($count_verygood * 100) / $count) }}%</b>
                                                                        </p>
                                                                        <img src="{{ asset('./images/logos/verygood.png') }}"
                                                                            alt="" style="width: 1em">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif --}}
                                                    </div>
                                                    <div
                                                        class="card-footer d-flex justify-content-between align-items-center">
                                                        <a href="" data-bs-toggle="offcanvas"
                                                            data-bs-target="#offcanvasProduct_{{ $product->id }}"
                                                            aria-controls="offcanvasProduct_{{ $product->id }}">Voir +</a>


                                                        {{-- OFFCANVAS --}}
                                                        <div class="offcanvas offcanvas-end offcanvasProduct"
                                                            data-bs-scroll="true" tabindex="-1"
                                                            id="offcanvasProduct_{{ $product->id }}"
                                                            aria-labelledby="offcanvasProductLabel_{{ $product->id }}">
                                                            <div class="offcanvas-header">
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                                <h4 class="offcanvas-title mt-3"
                                                                    id="offcanvasProductLabel_{{ $product->id }}">
                                                                    <b>{{ $product->name }}</b>
                                                                </h4>
                                                            </div>
                                                            <div class="offcanvas-body">
                                                                <div class="col-sm-11 col-12 mx-auto text-center">
                                                                    <p class="desc_gamme_product">{{ $product->desc }}</p>
                                                                    <img class="img_gamme_product"
                                                                        src="{{ asset('./images/' . $product->image) }}"
                                                                        alt="image du produit atelier 1830">
                                                                    <p class="fulldesc_gamme_product">
                                                                        {{ $product->full_desc }}
                                                                    </p>
                                                                    {{-- <form method="POST"
                                                                        action="{{ route('cart.add', $product->id) }}"
                                                                        class="form-inline d-inline-block">
                                                                        {{ csrf_field() }}
                                                                        <input type="hidden" name="quantity"
                                                                            placeholder="Quantité ?" value="1"
                                                                            class="form-control mr-2" style="width: 80px">
                                                                        <input type="submit" class="btn btn-outline-light"
                                                                            value="Ajouter au panier" />
                                                                    </form> --}}
                                                                </div>
                                                                <div class="row">
                                                                    <img class="mx-auto"
                                                                        src="{{ asset('./images/lelogo/titre_blanc_centré_sans_fond.png') }}"
                                                                        alt="logo pour commentaire" style="width: 80%;">
                                                                </div>

                                                                {{-- @if (Auth::user())
                                                                    @if (!Auth::user()->hasVotedForProduct($product->id))
                                                                        <h4 class="mt-5 text-center">Cet article vous plaît
                                                                            ?
                                                                        </h4>
                                                                        <form action="{{ route('satisfactions.store') }}"
                                                                            method="post" id="satisfactionForm">
                                                                            @csrf
                                                                            <div class="row mt-4 vote_icon mx-auto"
                                                                                style="width: 90%">
                                                                                <div class="col-4 badicon">
                                                                                    <button type="submit" name="rating"
                                                                                        value="bad"
                                                                                        class="btn rating-button">
                                                                                        <img src="{{ asset('./images/logos/bad.png') }}"
                                                                                            alt="">
                                                                                    </button>
                                                                                </div>
                                                                                <div class="col-4 goodicon">
                                                                                    <button type="submit" name="rating"
                                                                                        value="good"
                                                                                        class="btn rating-button">
                                                                                        <img src="{{ asset('./images/logos/good.png') }}"
                                                                                            alt="">
                                                                                    </button>
                                                                                </div>
                                                                                <div class="col-4 verygoodicon">
                                                                                    <button type="submit" name="rating"
                                                                                        value="verygood"
                                                                                        class="btn rating-button">
                                                                                        <img src="{{ asset('./images/logos/verygood.png') }}"
                                                                                            alt="">
                                                                                    </button>
                                                                                </div>
                                                                                <input type="hidden" name="productId"
                                                                                    value="{{ $product->id }}">
                                                                            </div>
                                                                        </form>
                                                                    @else
                                                                        <h4 class="mt-5 text-center">Vous avez déjà voté.
                                                                        </h4>
                                                                        <div class="row mt-4 vote_icon mx-auto"
                                                                            style="width: 90%">
                                                                            <div class="col-4 badicon">
                                                                                <img src="{{ asset('./images/logos/bad.png') }}"
                                                                                    alt=""
                                                                                    style="width: 4em; opacity: 0.4">
                                                                            </div>
                                                                            <div class="col-4 goodicon">
                                                                                <img src="{{ asset('./images/logos/good.png') }}"
                                                                                    alt=""
                                                                                    style="width: 4em; opacity: 0.4">
                                                                            </div>
                                                                            <div class="col-4 verygoodicon">
                                                                                <img src="{{ asset('./images/logos/verygood.png') }}"
                                                                                    alt=""
                                                                                    style="width: 4em; opacity: 0.4">
                                                                            </div>
                                                                        </div>

                                                                        @foreach ($product->satisfactions as $satisfaction)
                                                                            @if ($satisfaction->pivot->user_id === Auth::user()->id)
                                                                                <form class="text-center mt-3"
                                                                                    action="{{ route('satisfactions.destroy', $satisfaction) }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <input type="hidden" name="productId"
                                                                                        value="{{ $product->id }}">
                                                                                    <button type="submit"
                                                                                        class="btn_delete_satisfaction">Annuler
                                                                                        mon vote</button>
                                                                                </form>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @else
                                                                    <div class="row mt-4 vote_icon mx-auto"
                                                                        style="width: 90%">
                                                                        <a href="{{ route('login') }}">Connectez-vous pour
                                                                            voter !</a>
                                                                        <div class="col-4 badicon">
                                                                            <img src="{{ asset('./images/logos/bad.png') }}"
                                                                                alt=""
                                                                                style="width: 4em; opacity: 0.4">
                                                                        </div>
                                                                        <div class="col-4 goodicon">
                                                                            <img src="{{ asset('./images/logos/good.png') }}"
                                                                                alt=""
                                                                                style="width: 4em; opacity: 0.4">
                                                                        </div>
                                                                        <div class="col-4 verygoodicon">
                                                                            <img src="{{ asset('./images/logos/verygood.png') }}"
                                                                                alt=""
                                                                                style="width: 4em; opacity: 0.4">
                                                                        </div>
                                                                    </div>
                                                                @endif --}}
                                                            </div>
                                                        </div>
                                                        {{-- FIN OFFCANVAS --}}

                                                        {{-- <form method="POST"
                                                            action="{{ route('cart.add', $product->id) }}"
                                                            class="form-inline d-inline-block">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="quantity"
                                                                placeholder="Quantité ?" value="1"
                                                                class="form-control mr-2" style="width: 80px">
                                                            <button type="submit" class="btn d-flex align-items-center">
                                                                <img type="submit"
                                                                    src="{{ asset('./images/logos/cart.png') }}"
                                                                    alt="" style="width:2em">
                                                            </button>
                                                        </form> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-terracotta"
                                        data-bs-dismiss="modal">Retour</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach




                {{-- ******************************************************************* --}}
                {{-- GAMMES DES PRODUITS LES MIEUX NOTES --}}
                {{-- ******************************************************************* --}}

                {{-- <div class="col-lg-4 p-5 pb-0 col-md-4 mx-auto survol" data-bs-toggle="modal"
                    data-bs-target="#modalProductsGamme_best_voted">
                    <a>
                        <img src="{{ asset('images/best_voted.jpg') }}" alt="titre_gammes">
                        <h2 class='text-center'>Les mieux notés</h2>
                    </a>
                </div>


                <div class="modal fade show_products_gamme" id="modalProductsGamme_best_voted" tabindex="-1"
                    aria-labelledby="modalProductsGammeLabel_best_voted" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h1 class="modal-title" id="modalProductsGammeLabel_best_voted">
                                    Les mieux notés</h1>
                            </div>
                            <div class="modal-body">
                                <div class="row ">
                                    @foreach ($products as $product)
                                        @php
                                            $count_bad = 0;
                                            $count_good = 0;
                                            $count_verygood = 0;
                                            $count = 0;
                                        @endphp
                                        @foreach ($product->satisfactions as $user)
                                            @if ($user->pivot->note === 'bad')
                                                @php
                                                    $count_bad++;
                                                @endphp
                                            @endif
                                            @if ($user->pivot->note === 'good')
                                                @php
                                                    $count_good++;
                                                @endphp
                                            @endif
                                            @if ($user->pivot->note === 'verygood')
                                                @php
                                                    $count_verygood++;
                                                @endphp
                                            @endif
                                            @php
                                                $count++;
                                            @endphp
                                        @endforeach
                                        @if ($product->satisfactions->count() > 0 && round(($count_verygood * 100) / $count) > 80)
                                            <div class="col-lg-3 m-2 mb-5 mx-auto">
                                                <div class="card mx-auto p-1">
                                                    <img src="{{ asset("images/$product->image") }}"
                                                        class=" mx-auto mt-3" alt="img_card_product" style="width:90%">
                                                    <h5 class="name_gamme_product">{{ $product->name }}</h5>
                                                    <div class="card-body">
                                                        <h5 class="card-title">Gamme : Les mieux notés</h5>
                                                        <hr>
                                                        <p class="card-text">{{ substr($product->desc, 0, 45) }} ...</p>

                                                        @if ($count)
                                                            <div class="stat_satis">
                                                                <div class="contain_stat_satis">
                                                                    <p style="color: red">
                                                                        <b>{{ round(($count_bad * 100) / $count) }}%</b>
                                                                    </p>
                                                                    <img src="{{ asset('./images/logos/bad.png') }}"
                                                                        alt="" style="width: 1em">
                                                                </div>
                                                                <div class="contain_stat_satis">
                                                                    <p style="color: rgb(255, 213, 0)">
                                                                        <b>{{ round(($count_good * 100) / $count) }}%
                                                                        </b>
                                                                    </p>
                                                                    <img src="{{ asset('./images/logos/good.png') }}"
                                                                        alt="" style="width: 1em">
                                                                </div>
                                                                <div class="contain_stat_satis">
                                                                    <p style="color: green">
                                                                        <b>{{ round(($count_verygood * 100) / $count) }}%</b>
                                                                    </p>
                                                                    <img src="{{ asset('./images/logos/verygood.png') }}"
                                                                        alt="" style="width: 1em">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="card-footer d-flex justify-content-between align-items-center">
                                                        <a href="" data-bs-toggle="offcanvas"
                                                            data-bs-target="#offcanvasProduct_best_voted_{{ $product->id }}"
                                                            aria-controls="offcanvasProduct_best_voted_{{ $product->id }}">Voir
                                                            +</a>


                                                        <div class="offcanvas offcanvas-end offcanvasProduct"
                                                            data-bs-scroll="true" tabindex="-1"
                                                            id="offcanvasProduct_best_voted_{{ $product->id }}"
                                                            aria-labelledby="offcanvasProductLabel_best_voted_{{ $product->id }}">
                                                            <div class="offcanvas-header">
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="offcanvas"
                                                                    aria-label="Close"></button>
                                                                <h4 class="offcanvas-title mt-3"
                                                                    id="offcanvasProductLabel_best_voted_{{ $product->id }}">
                                                                    <b>{{ $product->name }}</b>
                                                                </h4>
                                                            </div>
                                                            <div class="offcanvas-body">
                                                                <div class="col-sm-11 col-12 mx-auto text-center">
                                                                    <p class="desc_gamme_product">{{ $product->desc }}</p>
                                                                    <img class="img_gamme_product"
                                                                        src="{{ asset('./images/' . $product->image) }}"
                                                                        alt="">
                                                                    <p class="fulldesc_gamme_product">
                                                                        {{ $product->full_desc }}
                                                                    </p>
                                                                    <form method="POST"
                                                                        action="{{ route('cart.add', $product->id) }}"
                                                                        class="form-inline d-inline-block">
                                                                        {{ csrf_field() }}
                                                                        <input type="hidden" name="quantity"
                                                                            placeholder="Quantité ?" value="1"
                                                                            class="form-control mr-2" style="width: 80px">
                                                                        <input type="submit"
                                                                            class="btn btn-outline-light"
                                                                            value="Ajouter au panier" />
                                                                    </form>
                                                                </div>

                                                                @if (Auth::user())
                                                                    @if (!Auth::user()->hasVotedForProduct($product->id))
                                                                        <h4 class="mt-5 text-center">Cet article vous plaît
                                                                            ?
                                                                        </h4>
                                                                        <form action="{{ route('satisfactions.store') }}"
                                                                            method="post" id="satisfactionForm">
                                                                            @csrf
                                                                            <div class="row mt-4 vote_icon mx-auto"
                                                                                style="width: 90%">
                                                                                <div class="col-4 badicon">
                                                                                    <button type="submit" name="rating"
                                                                                        value="bad"
                                                                                        class="btn rating-button">
                                                                                        <img src="{{ asset('./images/logos/bad.png') }}"
                                                                                            alt="">
                                                                                    </button>
                                                                                </div>
                                                                                <div class="col-4 goodicon">
                                                                                    <button type="submit" name="rating"
                                                                                        value="good"
                                                                                        class="btn rating-button">
                                                                                        <img src="{{ asset('./images/logos/good.png') }}"
                                                                                            alt="">
                                                                                    </button>
                                                                                </div>
                                                                                <div class="col-4 verygoodicon">
                                                                                    <button type="submit" name="rating"
                                                                                        value="verygood"
                                                                                        class="btn rating-button">
                                                                                        <img src="{{ asset('./images/logos/verygood.png') }}"
                                                                                            alt="">
                                                                                    </button>
                                                                                </div>
                                                                                <input type="hidden" name="productId"
                                                                                    value="{{ $product->id }}">
                                                                            </div>
                                                                        </form>
                                                                    @else
                                                                        <h4 class="mt-5 text-center">Vous avez déjà voté.
                                                                        </h4>
                                                                        <div class="row mt-4 vote_icon mx-auto"
                                                                            style="width: 90%">
                                                                            <div class="col-4 badicon">
                                                                                <img src="{{ asset('./images/logos/bad.png') }}"
                                                                                    alt=""
                                                                                    style="width: 4em; opacity: 0.4">
                                                                            </div>
                                                                            <div class="col-4 goodicon">
                                                                                <img src="{{ asset('./images/logos/good.png') }}"
                                                                                    alt=""
                                                                                    style="width: 4em; opacity: 0.4">
                                                                            </div>
                                                                            <div class="col-4 verygoodicon">
                                                                                <img src="{{ asset('./images/logos/verygood.png') }}"
                                                                                    alt=""
                                                                                    style="width: 4em; opacity: 0.4">
                                                                            </div>
                                                                        </div>

                                                                        @foreach ($product->satisfactions as $satisfaction)
                                                                            @if ($satisfaction->pivot->user_id === Auth::user()->id)
                                                                                <form class="text-center mt-3"
                                                                                    action="{{ route('satisfactions.destroy', $satisfaction) }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <input type="hidden" name="productId"
                                                                                        value="{{ $product->id }}">
                                                                                    <button type="submit"
                                                                                        class="btn_delete_satisfaction">Annuler
                                                                                        mon vote</button>
                                                                                </form>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @else
                                                                    <div class="row mt-4 vote_icon mx-auto"
                                                                        style="width: 90%">
                                                                        <a href="{{ route('login') }}">Connectez-vous pour
                                                                            voter !</a>
                                                                        <div class="col-4 badicon">
                                                                            <img src="{{ asset('./images/logos/bad.png') }}"
                                                                                alt=""
                                                                                style="width: 4em; opacity: 0.4">
                                                                        </div>
                                                                        <div class="col-4 goodicon">
                                                                            <img src="{{ asset('./images/logos/good.png') }}"
                                                                                alt=""
                                                                                style="width: 4em; opacity: 0.4">
                                                                        </div>
                                                                        <div class="col-4 verygoodicon">
                                                                            <img src="{{ asset('./images/logos/verygood.png') }}"
                                                                                alt=""
                                                                                style="width: 4em; opacity: 0.4">
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <form method="POST"
                                                            action="{{ route('cart.add', $product->id) }}"
                                                            class="form-inline d-inline-block">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="quantity"
                                                                placeholder="Quantité ?" value="1"
                                                                class="form-control mr-2" style="width: 80px">
                                                            <button type="submit" class="btn d-flex align-items-center">
                                                                <img type="submit"
                                                                    src="{{ asset('./images/logos/cart.png') }}"
                                                                    alt="" style="width:2em">
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-terracotta" data-bs-dismiss="modal">Retour</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
@endsection
