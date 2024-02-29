<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Atelier 1830, tapisserie en décoration, Versailles. La tapisserie, un art ancestral qui sublime votre intérieur. L'atelier 1830 vous propose des rideaux, des coussins ou revêtements de lit sur mesure, réalisées par des artisans qualifiés. Choisissez le motif, les couleurs et les dimensions qui vous correspondent pour une décoration unique et raffinée.">
    <meta name="keywords"
        content="atelier 1830, atelier1830, atelier, coussin, coussin d'assise, coussin décoratif, coussin de sol, coussin de dossier, coussin de tête, coussin de voyage, coussin de plage, coussin de voiture, coussin de maternité, coussin ergonomique, rideau, rideau occultant, rideau voilage, rideau brise-bise, rideau thermique, rideau sur mesure, rideau à œillets, rideau à pattes, rideau à plis flamands, rideau à festons, rideau à franges, housse de couette, taie d'oreiller, drap housse, drap plat, plaid, dessus de lit, couette, matelas, housse, housse de canapé, housse de fauteuil, housse de chaise, housse de table, housse de coussin, housse de matelas, housse de sommier, matelas, matelas à ressorts, matelas en mousse, matelas en latex, matelas à mémoire de forme, matelas orthopédique, matelas universel, matelas enfant, matelas bébé, matelas de camping">
    <title>@yield('title')</title>


    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.bunny.net"> --}}
    {{-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Passions+Conflict&display=swap"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/a6ce60fee1.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css', 'resources/css/contact.css', 'resources/css/politiques.css', 'resources/css/pasapas.css', 'resources/css/comments.css', 'resources/css/cart.css', 'resources/css/catalogue.css', 'resources/css/gammes.css', 'resources/css/backoffice.css', 'resources/css/connection.css', 'resources/css/edit.css'])


    <style id="antiClickjack">
        body {
            display: none !important;
        }
    </style>
    <script type="text/javascript">
        if (self === top) {
            var antiClickjack = document.getElementById("antiClickjack");
            antiClickjack.parentNode.removeChild(antiClickjack);
        } else {
            top.location = self.location;
        }
    </script>
</head>

<body @if (Route::currentRouteName() == 'users.edit' || request()->is('register') || request()->is('login')) class="fond-terracotta-login" @endif>
    <div class="loader">
        A
        <div class="circle-loader"></div>
        <div class="circle-loader-left"></div>
    </div>


    <div class="cursor-two-circle"></div>
    <div class="cursor-circle"></div>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm sticky-top">
            <div class="container-lg">
                <a class="me-1 navbar-brand" href="{{ url('/home') }}">
                    <img class="" src="{{ asset('images/lelogo/noir_sans_fond.png') }}" alt="logo-atelier1830">
                </a>
                {{-- <a href="{{ url('/home') }}">
                    <img class="logo_lilscreen" src="{{ asset('images/lelogo/noir_sans_fond.png') }}"
                        alt="logo-atelier1830">
                </a> --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ">
                        <a href="{{ route('home') }}"
                            class="nav-item nav-link {{ request()->is('home') || request()->is('/') ? 'actived' : '' }}">Accueil</a>
                        <a href="{{ route('pasapas') }}"
                            class="nav-item nav-link {{ request()->is('pasapas') ? 'actived' : '' }}">Pas à pas</a>
                        <a href="{{ route('gammes.index') }}"
                            class="nav-item nav-link {{ request()->is('gammes') ? 'actived' : '' }}">Gammes &
                            Produits</a>
                        <a href="{{ route('catalogues.index') }}"
                            class="nav-item nav-link {{ request()->is('catalogues') ? 'actived' : '' }}">Galerie</a>
                        <a href="{{ route('contact') }}"
                            class="nav-item nav-link {{ request()->is('contact') ? 'actived' : '' }}">Contact</a>


                        <li class="nav-item nav-link dropdown">
                            <a id="navbarDropdownAvis"
                                class="nav-link dropdown-toggle {{ request()->is('comments') ? 'actived' : '' }}"
                                href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" v-pre>
                                Avis
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAvis">
                                <a href="#" class="dropdown-item" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasComment" aria-controls="offcanvasComment">Laisser
                                    un avis</a>
                                <a class="dropdown-item" href="{{ route('comments.index') }}">Voir les avis</a>
                            </div>
                        </li>



                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto right_side_navbar">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('login') ? 'actived' : '' }}"
                                        href="{{ route('login') }}">{{ __('Connexion') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('register') ? 'actived' : '' }}"
                                        href="{{ route('register') }}">{{ __('Inscription') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- <li class="nav-item display_link" style="position:relative;">
                                <div class="cart-container">
                                    <a class="nav-link {{ request()->is('cart') ? 'actived' : '' }}"
                                        href="{{ route('cart.show') }}">
                                        <img src="{{ asset('./images/logos/cart.png') }}" alt=""
                                            style="width: 2em">
                                    </a>
                                    <img class="round-cart" src="{{ asset('./images/logos/round-cart.png') }}"
                                        alt="">

                                    @php
                                        $totalQuantity = 0;
                                        if (session()->has('cart') && count(session('cart')) > 0) {
                                            foreach (session('cart') as $item) {
                                                $totalQuantity += $item['quantity'];
                                            }
                                        }
                                    @endphp

                                    <span class="cart-count">{{ $totalQuantity }}</span>
                                </div>
                            </li> --}}
                            <li class="nav-item display_link dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstname }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('users.edit', $user = Auth::user()) }}">
                                        {{ __('Mon compte') }}
                                    </a>
                                    @if (Auth::user() && Auth::user()->isAdmin())
                                        <a class="dropdown-item" href="{{ route('admin') }}">
                                            {{ __('Back-Office') }}
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Deconnexion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- @unless (request()->is('pasapas') || request()->is('catalogues') || request()->is('login') || request()->is('contact') || request()->is('register') || Route::currentRouteName() == 'users.edit')
            <div class="body-background">
                <img src="./images/IMG20230606112058.webp" alt="image de fond atelier 1830">
            </div>
        @endunless --}}

        {{-- @if (Route::currentRouteName() == 'users.edit')
            <div class="body-background">
                <img src="../../images/IMG20230606112058.webp" alt="image de fond atelier 1830">
            </div>
        @endif --}}

        @if (request()->is('/') || request()->is('home') || request()->is('admin') || request()->is('comments'))
            <div class="body-background">
                <img src="./images/IMG20230606112058.webp" alt="image de fond atelier 1830">
            </div>
        @elseif (request()->is('pasapas'))
            <div class="body-background">
                <img src="./images/_DSC0019-2.jpg" alt="image de fond atelier 1830">
            </div>
        @elseif (request()->is('gammes'))
            <div class="body-background">
                <img src="./images/default_picture3.jpg" alt="image de fond atelier 1830">
            </div>
        @elseif (request()->is('catalogues'))
            <div class="body-background">
                <img src="./images/default_picture3.jpg" alt="image de fond atelier 1830">
            </div>
        @elseif (request()->is('contact'))
            <div class="body-background">
                <img src="./images/_DSC0019-2.jpg" alt="image de fond atelier 1830">
            </div>
        @elseif (request()->is('login') || request()->is('register'))
            <div class="body-background-login">
                <img src="./images/lelogo/titre_blanc_centré_sans_fond.png" alt="image de fond atelier 1830">
            </div>
        @elseif (Route::currentRouteName() == 'users.edit')
            <div class="body-background-login">
                <img src="../../images/lelogo/titre_blanc_centré_sans_fond.png" alt="image de fond atelier 1830">
            </div>
        @endif





        <div class="offcanvas offcanvas-start pt-4" data-bs-scroll="true" tabindex="-1" id="offcanvasComment"
            aria-labelledby="offcanvasCommentLabel">
            <div class="offcanvas-header">
                <h4 class="offcanvas-title" id="offcanvasCommentLabel">Postez votre commentaire !
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form action="{{ route('comments.store') }}" method="post" id="form_avis">
                    @csrf

                    @if (Auth::user())
                        <div class="col-md-10 mb-3">
                            <label for="title" class="form-label">Titre</label>
                            <div id="error-message" class="text-dark" style="font-weight: bold"></div>
                            <input required type="text" class="form-control" name="title" id="title"
                                placeholder="Excellent !" maxlength="80">
                            <p id="char-count-title">0/80</p>
                        </div>
                        <input type="hidden" id="note" name="note" value="" class="form-group"
                            required>
                        <div id="error-message-star" class="text-dark" style="font-weight: bold"></div>
                        <div class="stars col-7 text-center">
                            <i class="star stargrey fas fa-star fa-2x" data-index="1" data-hover="1"></i>
                            <i class="star stargrey fas fa-star fa-2x" data-index="2" data-hover="2"></i>
                            <i class="star stargrey fas fa-star fa-2x" data-index="3" data-hover="3"></i>
                            <i class="star stargrey fas fa-star fa-2x" data-index="4" data-hover="4"></i>
                            <i class="star stargrey fas fa-star fa-2x" data-index="5" data-hover="5"></i>
                        </div>
                        <div class="col-md-12">
                            <label for="comment" class="form-label">Votre message</label>
                            <div id="error-message-content" class="text-dark" style="font-weight: bold"></div>
                            <textarea type="text" class="form-control" name="content" id="content" placeholder="Ecrivez votre commentaire"
                                required maxlength="1000"></textarea>
                            <p id="char-count-content">0/1000</p>
                        </div>
                        <button type="submit" class="btn btn-outline-light mt-3" id="submit-button">Publier</button>
                    @else
                        <div class="col-md-10 mb-3">
                            <label for="title" class="form-label">Titre</label>
                            <input type="text" class="form-control" name="title" id="title" readonly
                                placeholder="Connectez-vous pour laisser un avis">
                        </div>
                        <div class="stars">
                            <i class="star stargrey fas fa-star fa-2x"></i>
                            <i class="star stargrey fas fa-star fa-2x"></i>
                            <i class="star stargrey fas fa-star fa-2x"></i>
                            <i class="star stargrey fas fa-star fa-2x"></i>
                            <i class="star stargrey fas fa-star fa-2x"></i>
                        </div>
                        <div class="col-md-12">
                            <label for="comment" class="form-label">Votre message</label>
                            <textarea type="text" class="form-control" name="content" id="content" readonly
                                placeholder="Connectez-vous pour laisser un avis"></textarea>
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-outline-light mt-3">Se connecter</a>
                    @endif
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const textarea = document.getElementById("content");
                            const p_input = document.getElementById("title");
                            const charCountDisplayContent = document.getElementById("char-count-content");
                            const charCountDisplayTitle = document.getElementById("char-count-title");

                            textarea.addEventListener("input", function() {
                                const charCountContent = textarea.value.length;
                                charCountDisplayContent.textContent = charCountContent + "/1000";
                            });
                            p_input.addEventListener("input", function() {
                                const charCountTitle = p_input.value.length;
                                charCountDisplayTitle.textContent = charCountTitle + "/80";
                            });
                        });
                    </script>


                    <script>
                        $(document).ready(function() {
                            $('#submit-button').click(function(e) {
                                // Empêche la soumission du formulaire par défaut
                                e.preventDefault();

                                if ($('#title').val().trim() === '') {
                                    // Vérifie si le champ titre est vide ou contient uniquement des espaces
                                    $('#error-message').text('Le champ titre est requis.');
                                } 
                                // Vérifie si une étoile a été sélectionnée
                                else if ($('.star.selected').length === 0) {
                                    $('#error-message-star').text('Veuillez choisir vos étoiles.');
                                } else if ($('#content').val().trim() === '') {
                                    // Vérifie si le champ content est vide ou contient uniquement des espaces
                                    $('#error-message-content').text('Veuillez rédiger votre message.');
                                } else {
                                    // Réinitialise le message d'erreur s'il y en avait un précédemment
                                    $('#error-message-star').text('');

                                    // Soumet le formulaire si tout est valide
                                    $('#form_avis').submit();
                                }
                            });

                            // Gestion de la sélection des étoiles
                            $('.star').click(function() {
                                $('.star').removeClass('selected');
                                $(this).addClass('selected');
                                // Met à jour la valeur du champ caché 'note' avec la note sélectionnée (par exemple, $(this).data('index'))
                                
                            });
                        });
                    </script>



                </form>
                <div class="row">

                    <img class="mx-auto" src="{{ asset('./images/lelogo/titre_blanc_centré_sans_fond.png') }}"
                        alt="logo pour commentaire" style="width: 80%;">
                </div>
            </div>
        </div>

        <main>
            @if (session()->has('message'))
                <div class="container-fluid text-center session_messages">
                    <p class="alert alert-success" id="successMessage">{{ session()->get('message') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="container-fluid text-center session_messages">
                    <div class="alert alert-danger col-md-6 mx-auto" id="errorMessage">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    @unless (request()->is('login') || request()->is('register'))
        <footer>
            <div class="row m-0 p-0">
                <div class="col-lg-4 text-center my-auto">
                    <img src="{{ asset('images/lelogo/design_blanc_sans_fond.png') }}" class=" img_logo"
                        alt="logo footer atelier 1830">
                    <div class="col-8 mx-auto mt-4">
                        <h5>L'Atelier 1830 est à votre écoute pour réaliser le décor qui pourra vous
                            satisfaire</h5>
                    </div>
                </div>
                <div class="col-lg-4 text-center my-auto">
                    <div class="icon_footer m-md-0 m-5 mb-1">
                        <a href="https://www.facebook.com/profile.php?id=100070320827389" target="_blank">
                            <img src="{{ asset('images/logos/facebook.png') }}" alt="logo facebook atelier 1830"></a>
                        <a href="https://www.instagram.com/atelier1830/" target="_blank">
                            <img src="{{ asset('images/logos/instagram.png') }}" alt="logo instagram atelier 1830"></a>
                        <a href="https://wa.me/330649587935" target="_blank">
                            <img src="{{ asset('images/logos/whatsapp.png') }}" alt="logo whatsapp atelier 1830"></a>
                    </div>
                    <br>

                    <div class="contact_mail">
                        <a href="mailto:sophievicari@gmail.com">sophievicari@gmail.com</a>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <iframe title="mapFooter"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d42045.53315152831!2d2.0779951645618593!3d48.803921141388756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e67db475f420bd%3A0x869e00ad0d844aba!2s78000%20Versailles!5e0!3m2!1sfr!2sfr!4v1706800864894!5m2!1sfr!2sfr"
                        width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            <section id="copyright">
                <div class="row p-0 m-0 text-center liens_footer">
                    <div class="col-md-4 mx-auto d-flex flex-column">
                        <span>2023 &copy; Atelier 1830</span>
                        <div class="d-flex justify-content-around">
                            <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                            <a class="nav-link" href="{{ route('politiques') }}">Mentions Légales</a>
                            <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                        </div>
                    </div>
                </div>
            </section>
        </footer>
    @endunless



    <script id="animation_gsap">
        $(".circle-loader").css("display", "block");
        $(window).on('load', function() {
            $(".loader").fadeOut(500);
        });

        const circle = document.querySelector('.circle-loader');
        const circleLeft = document.querySelector('.circle-loader-left');
        const cursorCircle = document.querySelector('.cursor-circle');
        const cursor = document.querySelector('.cursor');
        const cursorTwoCircle = document.querySelector('.cursor-two-circle');

        function rotateElement(element, rotationAngle, duration) {
            gsap.to(element, {
                rotation: rotationAngle,
                duration: duration,
                transformOrigin: 'center center',
                ease: "linear",
                repeat: -1,
            });
        }

        function follow(element, stagger, offsetX, offsetY) {
            gsap.set(element, {
                xPercent: -50,
                yPercent: -50,
            });

            window.addEventListener('mousemove', e => {
                gsap.to(element, stagger, {
                    x: e.clientX + offsetX,
                    y: e.clientY + offsetY,
                    ease: "none",
                });
            });
        }

        function changeStyle(element, from, to, balise = []) {
            let changeColor = false

            document.addEventListener('mouseover', function(e) {
                currentElement = e.target;
                if ((currentElement && (currentElement.getAttribute("animate"))) || (currentElement && balise.map(
                        tag => tag.toUpperCase()).includes(currentElement.nodeName))) {
                    gsap.to(element, 0.1, to);
                } else {
                    gsap.to(element, 0.1, from);
                }
            });
        }

        rotateElement(cursorCircle, 315, 2);
        rotateElement(cursorTwoCircle, 315, 2);
        rotateElement(circle, 360, 1);
        rotateElement(circleLeft, -360, 1);

        follow(cursorCircle, 0.3, -20, 15)
        follow(cursorTwoCircle, 0.5, -20, 15)
        changeStyle(cursorTwoCircle, {
            rotate: '45',
            borderRadius: '5px',
            scale: 1,
        }, {
            rotate: '0',
            borderRadius: '50%',
            scale: 1.6,

        }, ["img"])
        changeStyle(cursorCircle, {
            rotate: '45',
            borderRadius: '3px',
            scale: 1,
        }, {
            rotate: '0',
            borderRadius: '50%',
            scale: 1.4,
        }, ["img"])
        // follow(cursor, 0, 0, 0)
    </script>
</body>

</html>
