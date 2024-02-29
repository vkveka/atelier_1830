@extends('layouts.app')


@section('title')
    BACK - OFFICE | Atelier 1830
@endsection


@section('content')
    <section id="back_office">
        <h1 class="title_section">Espace Administrateur - <span>Back-Office</span></h1>
        <div class="accordion accordion-flush mx-auto" id="accordionFlushExample">

            {{-- Accordion Messages Users --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed asking_collapse" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseAskings" aria-expanded="false" aria-controls="collapseAskings">
                        <b>MESSAGES &nbsp;DES &nbsp;UTILISATEURS</b>
                    </button>
                </h2>
                <div id="collapseAskings" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">

                        <div class="back_office_nav_messages row mx-auto text-center">
                            <span class="col-5 one selected_span" data-status="0">Nouveaux messages</span>
                            <span class="col-5 two" data-status="1">Messages traités</span>
                        </div>

                        <script>
                            $(document).ready(function() {
                                $(".back_office_nav_messages span").click(function() {
                                    var status = $(this).data("status");

                                    // Mettez en évidence le span sélectionné
                                    $(".back_office_nav_messages span").removeClass("selected_span");
                                    $(this).addClass("selected_span");

                                    // Afficher les askings en fonction du statut sélectionné
                                    if (status === 0) {
                                        $(".asking").removeClass("hidden");
                                        $(".asking[data-status='1']").addClass("hidden");
                                    } else if (status === 1) {
                                        $(".asking").removeClass("hidden");
                                        $(".asking[data-status='0']").addClass("hidden");
                                    }
                                });
                            });
                        </script>

                        <style>
                            .hidden {
                                display: none;
                            }
                        </style>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            @foreach ($askings as $asking)
                                <tbody class="asking @if ($asking->status == 1) hidden @endif"
                                    data-status="{{ $asking->status }}">
                                    <tr class="{{ $asking->status ? 'etat_style' : '' }}">
                                        @php
                                            setlocale(LC_ALL, 'fr_FR', 'fra_FRA');
                                        @endphp
                                        <td>Le <span
                                                class="datetime_backoffice">{{ strftime('%d %B %Y', strtotime($asking->created_at)) }}</span>
                                            à
                                            <span
                                                class="datetime_backoffice">{{ $asking->created_at->format('H:i') }}</span>
                                        </td>

                                        <td>{{ $asking->firstname }}</td>
                                        <td>{{ $asking->lastname }}</td>
                                        <td>{{ $asking->email }}</td>
                                        <td>{{ $asking->phone }}</td>
                                        <td>

                                            <!-- Button modal -->
                                            <a class="au_red" data-bs-toggle="modal"
                                                data-bs-target="#askingModal_{{ $asking->id }}">
                                                Voir le message
                                            </a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="askingModal_{{ $asking->id }}" tabindex="-1"
                                                aria-labelledby="askingModal_Label_{{ $asking->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="askingModal_Label_{{ $asking->id }}">
                                                                Message envoyé par
                                                                <b>{{ $asking->firstname . ' ' . $asking->lastname }}</b>
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-3">
                                                                {!! nl2br(e($asking->content)) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                        <td class="modif_backoffice">
                                            <form action="{{ route('askings.update', $asking->id) }}" method="post"
                                                id="updateForm{{ $asking->id }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input statusSwitch" name="status"
                                                        type="checkbox" role="switch" id="statusSwitch{{ $asking->id }}"
                                                        value="{{ $asking->status }}"
                                                        {{ $asking->status ? 'checked' : '' }}>
                                                </div>


                                                <script>
                                                    const switchInput{{ $asking->id }} = document.getElementById('statusSwitch{{ $asking->id }}');
                                                    const form{{ $asking->id }} = document.getElementById('updateForm{{ $asking->id }}');

                                                    switchInput{{ $asking->id }}.addEventListener('change', function() {
                                                        // Mettre à jour la valeur de la case à cocher en fonction de son état
                                                        if (this.checked) {
                                                            this.value = 1;
                                                        } else {
                                                            this.value = 0;
                                                        }
                                                    });

                                                    switchInput{{ $asking->id }}.addEventListener('change', function() {
                                                        // Soumettre automatiquement le formulaire lorsque le switch est modifié
                                                        form{{ $asking->id }}.submit();
                                                    });
                                                </script>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>



            {{-- Accordion Gammes --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        GAMMES
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gammes as $gamme)
                                    <tr>
                                        <th scope="row">{{ $gamme->id }}</th>
                                        <td>{{ $gamme->name }}</td>
                                        <td class="d-flex modif_backoffice">
                                            <form action="{{ route('gammes.update', $gamme) }}" method="post"
                                                id="form_edit_gamme_{{ $gamme->id }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                {{-- MODAL DE MODIFICATION DE GAMME --}}
                                                <!-- Button modal -->
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#editGammeModal_{{ $gamme->id }}">
                                                    <img src="{{ asset('images/logos/edit.png') }}" class="lil_icon_action"
                                                        alt="edit">
                                                </a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="editGammeModal_{{ $gamme->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="editGammeModalLabel_{{ $gamme->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="editGammeModalLabel_{{ $gamme->id }}">
                                                                    Modification de la gamme</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group mb-3">
                                                                    <label for="name">Modifier le
                                                                        nom de la
                                                                        gamme</label>
                                                                    <input required type="text" class="form-control"
                                                                        placeholder="modifier" name="name"
                                                                        value="{{ $gamme->name }}" id="name">
                                                                </div>


                                                                <div class="form-group mb-3">
                                                                    <label for="image">Image</label>
                                                                    <img src="{{ asset('./images/' . $gamme->image) }}"
                                                                        alt="Image de fond de la gamme"
                                                                        style="width: 10%">
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label for="newImage">Nouvelle image de fond</label>
                                                                    <input type="file" class="form-control"
                                                                        name="newImage" id="newImage">
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Enregistrer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </form>
                                            <form id="form_delete_gamme_{{ $gamme->id }}"
                                                action="{{ route('gammes.destroy', $gamme) }}" method="post">
                                                @csrf
                                                @method('delete')


                                                {{-- MODAL DE SUPPRESSION DE GAMME --}}
                                                <!-- Button modal -->
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#deleteGammeModal_{{ $gamme->id }}">
                                                    <img src="{{ asset('images/logos/delete.png') }}"
                                                        class="lil_icon_action" alt="delete">
                                                </a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteGammeModal_{{ $gamme->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="deleteGammeModalLabel_{{ $gamme->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="deleteGammeModalLabel_{{ $gamme->id }}">
                                                                    Suppression de gamme</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Voulez-vous vraiment supprimer votre gamme ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Supprimer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                        <form action="{{ route('gammes.store') }}" method="post" id="form_store_gamme"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- MODAL D'AJOUT DE GAMME --}}
                            <!-- Button modal -->
                            <button class="btn btn-terracotta" data-bs-toggle="modal" data-bs-target="#storeGammeModal">
                                + Ajouter une gamme
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="storeGammeModal" tabindex="-1"
                                aria-labelledby="storeGammeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="storeGammeModalLabel">
                                                Ajouter une gamme</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label for="name">Nom de la
                                                    gamme</label>
                                                <input required type="text" class="form-control"
                                                    placeholder="modifier" name="name" value="" id="name">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="image">Image de fond</label>
                                                <input type="file" class="form-control" placeholder="modifier"
                                                    name="image" value="" id="image">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-danger">Enregistrer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Accordion Products --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        PRODUITS
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <form action="{{ route('products.store') }}" method="post" id="form_store_product"
                            class="m-4" enctype="multipart/form-data">
                            @csrf

                            {{-- MODAL D'AJOUT DE PRODUIT --}}
                            <!-- Button modal -->
                            <button class="btn btn-terracotta" data-bs-toggle="modal"
                                data-bs-target="#storeProductModal">
                                + Ajouter un produit
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="storeProductModal" tabindex="-1"
                                aria-labelledby="storeProductModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="storeProductModalLabel_">
                                                Ajouter un produit</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="form-group mb-3 col-sm-6">
                                                    <label for="name">Nom du produit</label>
                                                    <input required type="text" class="form-control"
                                                        placeholder="modifier" name="name" value=""
                                                        id="name">
                                                </div>

                                                <div class="form-group mb-3 col-sm-6">
                                                    <label for="desc">Description</label>
                                                    <input required type="text" class="form-control"
                                                        placeholder="modifier" name="desc" value=""
                                                        id="desc">
                                                </div>
                                                <div class="form-group mb-3 col-sm-6">
                                                    <label for="price">Prix</label>
                                                    <input type="number" class="form-control" placeholder="modifier"
                                                        name="price" value="" id="price">
                                                </div>
                                                <div class="form-group mb-3 col-sm-6">
                                                    <label for="full_desc">Description longue</label>
                                                    <textarea required placeholder="Ajouter ici la description longue..." class="form-control" name="full_desc"
                                                        id="full_desc"></textarea>
                                                </div>
                                                <div class="form-group mb-3 col-sm-6">
                                                    <label for="image">Image</label>
                                                    <input required type="file" class="form-control" name="image"
                                                        id="image">
                                                </div>
                                                <div class="form-group mb-3 col-sm-6">
                                                    <label for="dispo">Disponibilité</label>
                                                    <select required name="dispo" class="form-select"
                                                        aria-label="Default select example">
                                                        <option selected disabled>Sélectionner la disponibilité</option>
                                                        <option value="1">Disponible</option>
                                                        <option value="0">Indisponible</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3 col-sm-6">
                                                    <label for="gamme_id">Gamme</label>
                                                    <select required name="gamme_id" class="form-select"
                                                        aria-label="Default select example">
                                                        <option selected disabled>Sélectionner la gamme</option>
                                                        @foreach ($gammes as $gamme)
                                                            <option value="{{ $gamme->id }}">{{ $gamme->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-danger">Enregistrer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <th scope="row"><img src="{{ asset('./images/' . $product->image) }}"
                                                alt="image du produit atelier 1830" style="width: 50px; max-height: 50px">
                                        </th>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ substr($product->desc, 0, 10) }}
                                            <span id="points_{{ $product->id }}">...</span>
                                            @if (strlen($product->desc) > 10)
                                                <div id="more-content_{{ $product->id }}" style="display: none;">
                                                    {{ $product->desc }}
                                                </div>
                                                <a class="seemore" id="show-more{{ $product->id }}">Voir
                                                    +</a>
                                            @endif
                                        </td>



                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const toggleButton = document.getElementById('show-more{{ $product->id }}');
                                                const moreContent = document.getElementById('more-content_{{ $product->id }}');
                                                const points = document.getElementById('points_{{ $product->id }}');

                                                if (toggleButton !== null) {

                                                    toggleButton.addEventListener('click', function() {
                                                        if (moreContent.style.display === 'none') {
                                                            moreContent.style.display = 'inline';
                                                            toggleButton.textContent = 'Voir -';
                                                            points.style.display = 'none';
                                                        } else {
                                                            moreContent.style.display = 'none';
                                                            toggleButton.textContent = 'Voir +';
                                                        }
                                                    });
                                                }
                                            });
                                        </script>




                                        <td>{{ $product->price }}€</td>
                                        <td class="d-flex modif_backoffice">
                                            <img data-bs-toggle="modal" data-bs-target="#showFullDesc"
                                                src="{{ asset('./images/logos/plus.png') }}" class="lil_icon_action"
                                                alt="icone voir plus atelier 1830">


                                            <!-- Modal -->
                                            <div class="modal fade" id="showFullDesc" tabindex="-1"
                                                aria-labelledby="showFullDescLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="showFullDescLabel">
                                                                <b>{{ $product->name }}</b>
                                                            </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ $product->full_desc }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('products.update', $product) }}" method="post"
                                                id="form_edit_product_{{ $product->id }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                {{-- MODAL DE MODIFICATION DE PRODUITS --}}
                                                <!-- Button modal -->
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#editProductModal_{{ $product->id }}">
                                                    <img src="{{ asset('images/logos/edit.png') }}"
                                                        class="lil_icon_action" alt="edit">
                                                </a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="editProductModal_{{ $product->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="editProductModalLabel_{{ $product->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="editProductModalLabel_{{ $product->id }}">
                                                                    Modification du produit</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="form-group mb-3 col-sm-6">
                                                                        <label for="name">Modifier le
                                                                            nom</label>
                                                                        <input required type="text"
                                                                            class="form-control" placeholder="modifier"
                                                                            name="name" value="{{ $product->name }}"
                                                                            id="name">
                                                                    </div>
                                                                    <div class="form-group mb-3 col-sm-6">
                                                                        <label for="desc">Modifier la
                                                                            description</label>
                                                                        <input required type="text"
                                                                            class="form-control" placeholder="modifier"
                                                                            name="desc" value="{{ $product->desc }}"
                                                                            id="desc">
                                                                    </div>

                                                                    <div class="form-group mb-3 col-sm-6">
                                                                        <label for="full_desc">Modifier le description
                                                                            longue</label>
                                                                        <textarea required class="form-control" name="full_desc" id="full_desc">{{ $product->full_desc }}</textarea>
                                                                    </div>
                                                                    <div class="form-group mb-3 col-sm-6">
                                                                        <label for="price">Modifier le prix</label>
                                                                        <input required type="number"
                                                                            class="form-control" placeholder="modifier"
                                                                            name="price" value="{{ $product->price }}"
                                                                            id="price">
                                                                    </div>
                                                                    <div class="form-group mb-3 col-sm-6">
                                                                        <img src="{{ asset('./images/' . $product->image) }}"
                                                                            alt="image du produit" style="width: 10%">
                                                                    </div>
                                                                    <div class="form-group mb-3 col-sm-6">
                                                                        <label for="newImage">Nouvelle image</label>
                                                                        <input type="file" class="form-control"
                                                                            name="newImage"
                                                                            id="newImage{{ $product->id }}">
                                                                    </div>
                                                                    <div class="form-group mb-3 col-sm-6">
                                                                        <label for="dispo">Modifier la
                                                                            disponibilité</label>
                                                                        <select required name="dispo"
                                                                            class="form-select"
                                                                            aria-label="Default select example">
                                                                            <option value="1"
                                                                                @if ($product->dispo) selected @endif>
                                                                                Disponible</option>
                                                                            <option value="0"
                                                                                @if (!$product->dispo) selected @endif>
                                                                                Indisponible</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mb-3 col-sm-6">
                                                                        <label for="gamme_id">Modifier l'Id de la
                                                                            gamme</label>
                                                                        @php
                                                                            $selectedGammeId = $product->gamme->id;
                                                                        @endphp

                                                                        <select required name="gamme_id"
                                                                            class="form-select"
                                                                            aria-label="Default select example">
                                                                            @foreach ($gammes as $gamme)
                                                                                <option value="{{ $gamme->id }}"
                                                                                    @if ($gamme->id === $selectedGammeId) selected @endif>
                                                                                    {{ $gamme->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Enregistrer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </form>
                                            <form id="form_delete_product_{{ $product->id }}"
                                                action="{{ route('products.destroy', $product) }}" method="post">
                                                @csrf
                                                @method('delete')


                                                {{-- MODAL DE SUPPRESSION DE PRODUIT --}}
                                                <!-- Button modal -->
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#deleteProductModal_{{ $product->id }}">
                                                    <img src="{{ asset('images/logos/delete.png') }}"
                                                        class="lil_icon_action" alt="delete">
                                                </a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteProductModal_{{ $product->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="deleteProductModalLabel_{{ $product->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="deleteProductModalLabel_{{ $product->id }}">
                                                                    Suppression du produit</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Voulez-vous vraiment supprimer votre produit ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Supprimer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>


                    </div>
                </div>
            </div>


            {{-- Accordion Commandes --}}
            {{-- <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        COMMANDES
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Numéro</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Id Client</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($commandes as $commande)
                                    <tr>
                                        <th scope="row">{{ $commande->id }}</th>
                                        <td>{{ $commande->numero }}</td>
                                        <td>{{ $commande->price }}€</td>
                                        <td>{{ $commande->user_id }}</td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div> --}}

            {{-- Accordion Commentaires --}}
            {{-- <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseComment" aria-expanded="false"
                        aria-controls="flush-collapseComment">
                        COMMENTAIRES
                    </button>
                </h2>
                <div id="flush-collapseComment" class="accordion-collapse collapse"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Auteur</th>
                                    <th scope="col">Commentaire</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comments as $comment)
                                    <tr>
                                        <th scope="row">{{ $comment->id }}</th>
                                        <td><b>{{ $comment->user->firstname . ' ' . $comment->user->lastname }}</b></td>
                                        <td>{{ $comment->content }}</td>
                                        <td class="d-flex modif_backoffice">
                                            <form id="form_delete_comment_{{ $comment->id }}"
                                                action="{{ route('comments.destroy', $comment) }}" method="post">
                                                @csrf
                                                @method('delete')


                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#deleteCommentModal_{{ $comment->id }}">
                                                    <img src="{{ asset('images/logos/delete.png') }}"
                                                        class="lil_icon_action" alt="delete">
                                                </a>

                                                <div class="modal fade" id="deleteCommentModal_{{ $comment->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="deleteCommentModalLabel_{{ $comment->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="deleteCommentModalLabel_{{ $comment->id }}">
                                                                    Suppression du commentaire</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Voulez-vous vraiment supprimer ce commentaire ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Supprimer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}



            {{-- Accordion Catalogue  --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseCatalogue" aria-expanded="false"
                        aria-controls="flush-collapseCatalogue">
                        GALERIE
                    </button>
                </h2>
                <div id="flush-collapseCatalogue" class="accordion-collapse collapse"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <table class="table">
                            <tbody>
                                <form action="{{ route('catalogues.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Titre de l'image">
                                        </div>
                                        <div class="col-sm-6 m-sm-0 mt-2">
                                            <input type="file" class="form-control" id="image" name="image">
                                        </div>
                                        <button type="submit" class="btn btn-terracotta my-3">Envoyer</button>
                                    </div>
                                </form>
                                <div class="row">
                                    @foreach ($cataloguesInverse as $catalogue)
                                        <div class="col-3">
                                            <div id="change_status_icon_id{{ $catalogue->id }}"
                                                class="change_status_icon" style="position: relative">
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#deleteCatalogueModal_{{ $catalogue->id }}">
                                                    <img src="{{ asset("./images/$catalogue->image") }}"
                                                        id="old{{ $catalogue->id }}" alt="image du catalogue"
                                                        class="upload_img_style"></a>

                                                <img class="icon_upload_img" src="{{ asset('./images/logos/eye.png') }}"
                                                    alt="upload new image">


                                                <div class="modal fade" id="deleteCatalogueModal_{{ $catalogue->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="deleteCatalogueModalLabel_{{ $catalogue->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="deleteCatalogueModalLabel_{{ $catalogue->id }}">
                                                                    Modification de l'image</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('catalogues.update', $catalogue) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <label for="newTilte"><b>Titre</b></label>
                                                                            <div class="col-md-10 col-9">
                                                                                <input type="text" class="form-control"
                                                                                    name="newTilte" id="newTilte"
                                                                                    value="{{ $catalogue->title }}"
                                                                                    required>
                                                                            </div>
                                                                            <button type="submit"
                                                                                class="btn btn-warning col-sm-2 col-3 text-light me-auto">Modifier</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('catalogues.destroy', $catalogue) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="lil_icon_action me-auto"><img
                                                                            src="./images/logos/trash.png"
                                                                            alt=""></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            {{-- Accordion Users --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                        UTILISATEURS
                    </button>
                </h2>
                <div id="flush-collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Mail</th>
                                        <th scope="col">Rôle</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <th scope="row">{{ $user->id }}</th>
                                            <td>{{ $user->firstname }}&nbsp;{{ $user->lastname }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role->role }}</td>
                                            <td class="d-flex align-items-center modif_backoffice">
                                                <form id="form_delete_user_{{ $user->id }}"
                                                    action="{{ route('users.destroy', $user) }}" method="post">
                                                    @csrf
                                                    @method('delete')

                                                    {{-- MODAL DE SUPPRESSION DE USER --}}
                                                    <!-- Button modal -->
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#deleteUserModal_{{ $user->id }}">
                                                        <img src="{{ asset('images/logos/delete.png') }}"
                                                            class="lil_icon_action" alt="delete">
                                                    </a>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="deleteUserModal_{{ $user->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteUserModalLabel_{{ $user->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5"
                                                                        id="deleteUserModalLabel_{{ $user->id }}">
                                                                        Suppression du User</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Voulez-vous vraiment supprimer votre User ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Annuler</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Supprimer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                @if ($user->role_id != 3)
                                                    <form id="form_ban_user_{{ $user->id }}"
                                                        action="{{ route('users.ban', $user) }}" method="post">
                                                        @csrf
                                                        @method('PUT')

                                                        {{-- MODAL DE SUPPRESSION DE USER --}}
                                                        <!-- Button modal -->
                                                        <a class="btn_ban" data-bs-toggle="modal"
                                                            data-bs-target="#banUserModal_{{ $user->id }}">
                                                            Bannir
                                                        </a>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="banUserModal_{{ $user->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="banUserModalLabel_{{ $user->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="banUserModalLabel_{{ $user->id }}">
                                                                            Bannissement du User</h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Voulez-vous vraiment bannir
                                                                        {{ $user->firstname . ' ' . $user->lastname }} ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Annuler</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Bannir</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @endif
                                                @if ($user->role_id === 3)
                                                    <img src="{{ asset('images/logos/ban.png') }}"
                                                        class="lil_icon_action" alt="ban"
                                                        style="width: 70px; vertical-align: center;">
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
