@extends('layouts.app')

@section('title')
    Connexion | Atelier 1830
@endsection

@section('content')
    <div class="container">
        <section id="login">
            <div class="col-xl-5 col-lg-8 col-md-10 col-12 mx-auto login-form">
                <h2 class="title_connection">{{ 'Connexion' }}</h2>
                <form action="{{ route('login') }}" class="row g-3 needs-validation d-flex flex-column" method="POST"
                    id="loginForm">
                    @csrf
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-at"></i></span>
                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" name="email" id="email" placeholder="Mail" required
                                    autocomplete="email">
                                <label for="email">Mail</label>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <div class="form-floating">
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"name="password"
                                    id="password" placeholder="Mot de passe" required autocomplete="new-password">
                                <label for="password">{{ __('Mot de passe') }}</label>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="row mb-3 col-md-6 col-10 mx-auto">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Se souvenir de moi') }}
                                </label>
                            </div>
                        </div>
                    </div> --}}


                    <div class="input-group">
                        <button type="submit" class="btn btn-terracotta col-md-12" id="submitButton">
                            {{ __('Connexion') }}
                        </button>
                    </div>

                    <div class="col-md-12">
                        <a class="btn btn-link" href="{{ route('register') }}">Pas encore inscrit ?</a>
                        {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Mot de passe oublié ?') }}
                                    </a>
                                @endif --}}
                    </div>
                </form>
            </div>
        </section>



    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function() {
                // Ajouter la classe pour montrer le spinner
                $('#submitButton').html('<i class="fa fa-spinner fa-spin"></i> Connexion...');
                $('#submitButton').prop('disabled', true);
            });
        });
    </script>
@endsection
