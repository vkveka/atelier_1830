@extends ('layouts.app')
@section('title')
    Mon compte
@endsection
@section('content')
    <script>
        function scrollToCollapse() {
            var element = document.getElementById("btnGlobalInfoUser");
            if (element) {
                element.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        }
    </script>

    <section class="user_page container my-5">
        <div class="globalBlocks">
            <div class="bloc_compte" data-bs-toggle="collapse" href="#collapseUserEdit" role="button" aria-expanded="false"
                aria-controls="collapseUserEdit" onclick="scrollToCollapse()">
                <h2 class="text-center d-inline-flex gap-1 " id="btnGlobalInfoUser">
                    <p>
                        Mes informations
                    </p>
                </h2>
                <i class="fa fa-2x fa-edit" style="color:#a44a4a"></i>
            </div>
            {{-- <div class="bloc_compte" data-bs-toggle="collapse" href="#collapseAvis" role="button" aria-expanded="false"
                aria-controls="collapseAvis">
                <h2 class="text-center d-inline-flex gap-1 ">
                    <p>
                        Mes commentaires
                    </p>
                </h2>
                <i class="fa fa-regular fa-2x fa-comment" style="color:#a44a4a"></i>
            </div> --}}
        </div>


        {{-- <div class="collapse" id="collapseAvis">
            test
        </div> --}}
        <div class="collapse" id="collapseUserEdit">
            <section id="user-edit">
                <div class="col-lg-10 col-md-10 col-12 mx-auto user-edit-form">

                    <form class="row needs-validation d-flex" action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- ESPACE INFO USER --}}
                        <div class="infos-user col-sm-6 mb-3 pe-4">
                            <h2 class="title_connection">{{ 'Informations' }}</h2>
                            {{--  --}}
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    <div class="form-floating">
                                        <input required type="text" class="form-control" placeholder="modifier"
                                            name="firstname" value="{{ $user->firstname }}" id="firstname">
                                        <label for="firstname">Nouveau prénom</label>
                                    </div>
                                </div>
                            </div>

                            {{--  --}}
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa fa-regular fa-user"></i></span>
                                    <div class="form-floating">
                                        <input required type="text" class="form-control" placeholder="modifier"
                                            name="lastname" value="{{ $user->lastname }}" id="lastname">
                                        <label for="lastname">Nouveau nom de famille</label>
                                    </div>
                                </div>
                            </div>

                            {{--  --}}
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa fa-at"></i></span>
                                    <div class="form-floating">
                                        <input required type="mail"
                                            class="form-control @error('email') is-invalid @enderror" placeholder="modifier"
                                            name="email" value="{{ $user->email }}" id="email">
                                        <label for="email">Nouveau mail</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ESPACE MDP USER --}}
                        <div class="mdp-user col-sm-6 text-center mb-1 ps-4">
                            <h2 class="title_connection">{{ 'Mot de passe' }}</h2>
                            <p class="d-inline-flex gap-1 mx-auto">
                                <a class="btn btn-terracotta mb-3" data-bs-toggle="collapse" href="#collapsePasswordUpdate"
                                    role="button" aria-expanded="false" aria-controls="collapsePasswordUpdate">
                                    Afficher le formulaire
                                </a>
                            </p>
                            <div class="collapse" id="collapsePasswordUpdate">
                                {{--  --}}
                                <div class="col-md-12">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        <div class="form-floating">

                                            <input id="oldPassword" type="password"
                                                class="form-control @error('oldPassword') is-invalid @enderror"
                                                name="oldPassword" placeholder="">
                                            <label for="oldPassword">{{ __('Ancien mot de passe') }}</label>
                                        </div>
                                        @error('oldPassword')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>



                                {{--  --}}
                                <div class="col-md-12">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        <div class="form-floating">

                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" placeholder="">
                                            <label for="password">{{ __('Nouveau mot de passe') }}</label>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Modification du mot de passe --}}
                                <div class="col-md-12">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        <div class="form-floating">

                                            <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" placeholder="">
                                            <label for="password-confirm">{{ __('Confirmation mot de passe') }}</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <button type="submit" class="btn btn-terracotta">Enregistrer les modifications</button>
                    </form>

                    <form class="col-4 mx-auto link_delete_account" action="{{ route('users.destroy', $user) }}"
                        method="post">
                        @csrf
                        @method('delete')

                        <!-- Button modal -->
                        <a class="link-delete" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Supprimer mon compte
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="0" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression de compte
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Voulez-vous vraiment supprimer votre compte ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        {{-- <div class="col-lg-6 mb-5 accordion accordion-flush mx-auto" id="accordionCommande">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseCommandes" aria-expanded="false" aria-controls="collapseCommandes">
                        Commandes réalisées
                    </button>
                </h2>

                <div id="collapseCommandes" class="accordion-collapse collapse" data-bs-parent="#accordionCommande">
                    <div class="accordion-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Numéro</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Retrait</th>
                                    <th scope="col">Détails</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->commandes as $commande)
                                    <tr>
                                        <td>{{ $commande->numero }}</td>
                                        <td><b>{{ $commande->price }}€</b></td>
                                        <td>@php
                                            echo \Carbon\Carbon::parse($commande->created_at)->translatedFormat('d F Y');
                                        @endphp</td>
                                        <td>@php
                                            echo \Carbon\Carbon::parse($commande->pickup_date)->translatedFormat('d F Y');
                                        @endphp</td>
                                        <td>
                                            <a href="{{ route('commandes.show', $commande) }}">Voir le détail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSatisfaction" aria-expanded="false"
                        aria-controls="collapseSatisfaction">
                        Mes votes
                    </button>
                </h2>

                <div id="collapseSatisfaction" class="accordion-collapse collapse"
                    data-bs-parent="#accordionSatisfaction">
                    <div class="accordion-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Produit</th>
                                    <th scope="col">Satisfaction</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            @foreach ($product->satisfactions as $satisfaction)
                                                @if ($satisfaction->pivot->user_id === Auth::user()->id)
                                                    {{ $satisfaction->pivot->note }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td><img src="{{ asset('./images/' . $product->image) }}" alt=""
                                                style="width: 70px" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvasProduct_{{ $product->id }}"
                                                aria-controls="offcanvasProduct_{{ $product->id }}">


                                            <div class="offcanvas offcanvas-end offcanvasProduct" data-bs-scroll="true"
                                                tabindex="-1" id="offcanvasProduct_{{ $product->id }}"
                                                aria-labelledby="offcanvasProductLabel_{{ $product->id }}">
                                                <div class="offcanvas-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                                        aria-label="Close"></button>
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
                                                            alt="" style="width: 100%">
                                                        <p class="fulldesc_gamme_product mt-3">
                                                            {{ $product->full_desc }}
                                                        </p>
                                                        <form method="POST"
                                                            action="{{ route('cart.add', $product->id) }}"
                                                            class="form-inline d-inline-block">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="quantity"
                                                                placeholder="Quantité ?" value="1"
                                                                class="form-control mr-2" style="width: 80px">
                                                            <input type="submit" class="btn btn-outline-light"
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
                                                                            value="bad" class="btn rating-button">
                                                                            <img src="{{ asset('./images/logos/bad.png') }}"
                                                                                alt="">
                                                                        </button>
                                                                    </div>
                                                                    <div class="col-4 goodicon">
                                                                        <button type="submit" name="rating"
                                                                            value="good" class="btn rating-button">
                                                                            <img src="{{ asset('./images/logos/good.png') }}"
                                                                                alt="">
                                                                        </button>
                                                                    </div>
                                                                    <div class="col-4 verygoodicon">
                                                                        <button type="submit" name="rating"
                                                                            value="verygood" class="btn rating-button">
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
                                                            <div class="row mt-4 vote_icon mx-auto" style="width: 90%">
                                                                <div class="col-4 badicon">
                                                                    <img src="{{ asset('./images/logos/bad.png') }}"
                                                                        alt="" style="width: 4em; opacity: 0.4">
                                                                </div>
                                                                <div class="col-4 goodicon">
                                                                    <img src="{{ asset('./images/logos/good.png') }}"
                                                                        alt="" style="width: 4em; opacity: 0.4">
                                                                </div>
                                                                <div class="col-4 verygoodicon">
                                                                    <img src="{{ asset('./images/logos/verygood.png') }}"
                                                                        alt="" style="width: 4em; opacity: 0.4">
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
                                                        <div class="row mt-4 vote_icon mx-auto" style="width: 90%">
                                                            <a href="">Connectez-vous pour voter !</a>
                                                            <div class="col-4 badicon">
                                                                <img src="{{ asset('./images/logos/bad.png') }}"
                                                                    alt="" style="width: 4em; opacity: 0.4">
                                                            </div>
                                                            <div class="col-4 goodicon">
                                                                <img src="{{ asset('./images/logos/good.png') }}"
                                                                    alt="" style="width: 4em; opacity: 0.4">
                                                            </div>
                                                            <div class="col-4 verygoodicon">
                                                                <img src="{{ asset('./images/logos/verygood.png') }}"
                                                                    alt="" style="width: 4em; opacity: 0.4">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @foreach ($product->satisfactions as $satisfaction)
                                                @if ($satisfaction->pivot->user_id === Auth::user()->id)
                                                    <form class="mt-3"
                                                        action="{{ route('satisfactions.destroy', $satisfaction) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="productId"
                                                            value="{{ $product->id }}">
                                                        <button type="submit" class="btn_delete_satisfaction"
                                                            style="color: #a44a4a">Annuler
                                                            mon vote</button>
                                                    </form>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
    </section>
@endsection
