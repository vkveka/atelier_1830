@extends('layouts.app')

@section('title')
    Contact | Atelier 1830
@endsection


@section('content')
    <section id="contact" class="mb-5">
        <div class="col-xl-7 col-lg-8 col-md-10 mx-auto contact-form">
            <h4 class="title_contact">Contactez-nous via ce formulaire pour nous poser toutes vos questions !</h4>
            <form action="{{ route('askings.store') }}" class="row g-3 needs-validation" method="post" id="contactForm">
                @csrf
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-regular fa-user"></i></span>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="firstname" id="fistname" placeholder="Nom"
                                required>
                            <label for="fistname">Nom</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Prénom"
                                required>
                            <label for="lastname">Prénom</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-at"></i></span>
                        <div class="form-floating">
                            <input type="email" class="form-control"name="email" id="email" placeholder="Mail"
                                required>
                            <label for="email">Mail</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                        <div class="form-floating">
                            <input type="number" class="form-control"name="phone" id="phone" placeholder="Téléphone"
                                required style="appearance: textfield; -webkit-appearance: textfield">
                            <label for="phone">Téléphone</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <textarea type="text" class="form-control" name="content" id="content" placeholder="Username" required></textarea>
                        <label for="content">Ecrivez votre message...</label>
                    </div>
                    <div class="col-12 mt-4">
                        <button class="btn btn-terracotta col-12" type="submit" id="submitButton">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('#contactForm').submit(function() {
                // Ajouter la classe pour montrer le spinner
                $('#submitButton').html('<i class="fa fa-spinner fa-spin"></i> Envoi en cours...');
                $('#submitButton').prop('disabled', true);
            });
        });
    </script>
@endsection
