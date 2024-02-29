@extends('layouts.app')

@section('title')
    Inscription | Atelier 1830
@endsection

@section('content')
    <div class="container">
        <section id="register">
            <div class="col-lg-8 col-md-10 mx-auto register-form">
                <h2 class="title_connection text-center">{{ 'Inscription' }}</h2>
                <form class="row needs-validation" method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf
                    <div class="col-sm-6">
                        <div class="input-group my-2">
                            <span class="input-group-text"><i class="fa fa-regular fa-user"></i></span>
                            <div class="form-floating">
                                <input id="lastname" type="text"
                                    class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                    value="{{ old('lastname') }}" required autocomplete="lastname" autofocus
                                    placeholder="Nom">
                                <label for="lastname">{{ __('Nom') }}</label>
                            </div>
                            @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>



                    <div class="col-sm-6">
                        <div class="input-group my-2">
                            <span class="input-group-text"><i class="fa fa-regular fa-user"></i></span>
                            <div class="form-floating">

                                <input id="firstname" type="text"
                                    class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                    value="{{ old('firstname') }}" required autocomplete="firstname" autofocus
                                    placeholder="Prénom">
                                <label for="firstname">{{ __('Prénom') }}</label>

                            </div>
                            @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="input-group my-2">
                            <span class="input-group-text"><i class="fa fa-at"></i></span>
                            <div class="form-floating">

                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" placeholder="Mail">
                                <label for="email">{{ __('Adresse mail') }}</label>

                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="input-group my-2">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <div class="form-floating">

                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password" placeholder="Mot de passe">
                                <label for="password">{{ __('Mot de passe') }}</label>

                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="input-group my-2">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <div class="form-floating">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirmer mot de passe">
                                <label for="password-confirm">{{ __('Confirmer mot de passe') }}</label>
                            </div>
                            @error('password-confirm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 mb-2 recommandation_cnil my-sm-auto">
                        <span>* 8 caractères au minimum</span>
                        <br>
                        <span>* 1 lettre majuscule et 1 lettre minuscule au minimum</span>
                        <br>
                        <span>* 1 chiffre au minimum</span>
                        <br>
                        <span>* 1 caractère spécial au minimum</span>
                    </div>

                    <div class="form-group">
                        <div class="d-flex align-items-center politique">
                            <input type="checkbox" class="" name="politique" id="politique"
                                onclick="toggleValidationButtonDisplay()">
                            <label for="" class="ms-2">J'ai lu et j'accepte les
                                <a href="{{ route('politiques') }}">mentions légales et la politique de
                                    confidentialité</a>
                            </label>
                        </div>

                        <div class="col-sm-6">
                            <span id="monSpan" class="text-center span_hidden">Cochez la case pour vous
                                inscrire.</span>
                        </div>
                    </div>

                    <div class="input-group">
                        <button type="button" class="btn btn-terracotta col-sm-6 mt-3 mx-auto" id="valider">
                            {{ __('Inscription') }}
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script>
        function toggleValidationButtonDisplay() {
            let checkbox = document.getElementById('politique');
            let boutonValider = document.getElementById('valider');
            if (checkbox.checked) {
                boutonValider.type = "submit";
                boutonValider.style.cursor = "pointer";
            } else {
                boutonValider.type = "button";
                boutonValider.style.cursor = "not-allowed";
            }


        }

        document.getElementById('valider').addEventListener('click', function() {
            var boutonValider = document.getElementById('valider');

            if (boutonValider.type === 'button') {
                var monSpan = document.getElementById('monSpan');
                monSpan.classList.remove('span_hidden');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#registerForm').submit(function() {
                // Ajouter la classe pour montrer le spinner
                $('#valider').html('<i class="fa fa-spinner fa-spin"></i> Inscription...');
                $('#valider').prop('disabled', true);
            });
        });
    </script>
@endsection
