@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div class="container" id="panier">
            @if (session()->has('cart') && count(session('cart')) > 0)
                <div class="col-md-10 mx-auto my-5">
                    <h1>Mon panier</h1>
                    <div class="table-responsive shadow mb-3 p-md-5 p-0 bg-light" style="border-radius: 10px">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix</th>
                                        <th>Quantité</th>
                                        <th>Total</th>
                                        <th>Opérations</th>
                                    </tr>
                                </thead>



                                <tbody>
                                    <!-- Initialisation du total général à 0 -->
                                    @php
                                        $total = 0;
                                    @endphp

                                    <!-- On parcourt les produits du panier en session : session('cart') -->
                                    @foreach (session('cart') as $key => $item)
                                        <!-- On incrémente le total général par le total de chaque produit du panier -->
                                        @php $total += $item['price'] * $item['quantity'] @endphp
                                        <tr>
                                            <td>
                                                <strong>
                                                    <div class="row">
                                                        <div class="col-xl-8">
                                                            <a class="me-3" title="Afficher le produit">
                                                                {{ $item['name'] }}
                                                            </a>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <a title="Afficher le produit"><img
                                                                    src="{{ asset('./images/' . $item['image']) }}"
                                                                    alt="photo du produit du panier" style="width: 4em"></a>
                                                        </div>
                                                    </div>
                                                </strong>
                                            </td>
                                            <td>{{ $item['price'] }}€</td>
                                            <td>
                                                <!-- Le formulaire de mise à jour de la quantité -->
                                                <form method="POST" action="{{ route('cart.add', $key) }}"
                                                    class="form-inline main_form">
                                                    @csrf
                                                    <input type="number" name="quantity" placeholder="Quantité ?"
                                                        value="{{ $item['quantity'] }}" class="form-control mr-2"
                                                        style="width: 80px">
                                                    <input type="submit" class="btn btn-outline-dark" value="Actualiser" />
                                                </form>
                                            </td>
                                            <td>
                                                <!-- Le total du produit = prix * quantité -->
                                                {{ $item['price'] * $item['quantity'] }}€
                                            </td>
                                            <td>
                                                <!-- Le Lien pour retirer un produit du panier -->
                                                <a href="{{ route('cart.remove', $key) }}" class="btn btn-outline-danger"
                                                    title="Retirer le produit du panier">Retirer</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr colspan="2">
                                        <td colspan="1" class="text-end"><b>Total général</b></td>
                                        <td colspan="2">
                                            <!-- On affiche total général -->
                                            <strong>{{ $total }}€</strong>
                                        </td>
                                        <td colspan="1"></td>
                                        <td colspan="2">
                                            <!-- Lien pour vider le panier -->
                                            <a class="au_red" href="{{ route('cart.empty') }}"
                                                title="Retirer tous les produits du panier">Vider le panier</a>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <form action="{{ route('commandes.store') }}" class="text-center" method="post" id="commandeForm">
                        @csrf
                        <input type="hidden" name="lastTotal" value="{{ $total }}">
                        <button type="submit" class="btn btn-terracotta mt-2">Valider la commande</button>
                    </form>


                    <script>
                        // Fonction pour soumettre le formulaire via AJAX
                        function submitForm() {
                            $.ajax({
                                url: $('#commandeForm').attr('action'),
                                type: 'POST',
                                data: $('#commandeForm').serialize(),
                                success: function(response) {

                                    $('#votreModal').modal('show');
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                }
                            });
                        }

                        $('#commandeForm').on('submit', function(event) {
                            event.preventDefault();
                            submitForm();
                        });
                    </script>




                    <!-- Modal -->
                    <div class="modal fade" id="votreModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h2 class="modal-title" id="staticBackdropLabel"><b>Commande validée.</b></h2>
                                </div>
                                <div class="modal-body">
                                    @foreach (session('cart') as $key => $item)
                                        <div class="row">
                                            <div class="col-12">
                                                @if ($item['quantity'] > 1)
                                                    {{ $item['quantity'] . 'x ' . $item['name'] . ' : ' . $item['quantity'] * $item['price'] }}
                                                    €
                                                @else
                                                    {{ $item['name'] . ' : ' . $item['quantity'] * $item['price'] }} €
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    <h5 class="mt-4">Total de la commande : {{ $total }} €</h5>
                                </div>
                                <div class="modal-footer" style="justify-content: start; flex-direction: column">
                                    <p style="font-weight: bold">Merci pour votre confiance !</p>
                                    <p style="font-weight: bold">Nous vous contacterons lorsque votre commande sera prête.
                                    </p>
                                    <button type="button" class="btn btn-terracotta"
                                        onclick="location.reload()">Retour</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            @else
                <div class="col-md-6 col-sm-8 col-11 my-5 mx-auto">
                    <h1>Mon Panier</h1>
                    <div class="alert alert-light d-flex flex-column align-items-center">
                        <b>Votre panier est vide</b>
                        <img src="{{ asset('./images/logos/empty_cart.png') }}" alt="panier vide" style="width: 10em">
                    </div>
                </div>
            @endif

        </div>
    @else
    @endif
@endsection
