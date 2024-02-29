@extends('layouts.app')

@section('title')
    Atelier 1830 - Tapisserie en décoration. Coussins, rideaux, housses, matelas.
@endsection

@section('content')
    <div class="row p-0 m-0 justify-content-center" style="--bs-gutter-x: 0;">

        <!-- **************** HEADER **************** -->
        <header>
            <div class="container text_header">
                <div class="row p-0 m-0">
                    <div class="col-md-12 text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h1>Atelier 1830</h1>
                        <h4>Tapissière en décors</h4>
                    </div>
                </div>
            </div>


            <!-- **************** CARROUSSEL **************** -->

            <div class="marquee">
                <ul class="marquee-content">
                    <li><img src="./images/default_picture1.jpg" alt="image carousel atelier 1830" data-bs-toggle="modal"
                            id="imageHome1" data-bs-target="#modalHome" onclick="ajouterClasseActive('imageHome1')"></li>
                    <li><img src="./images/default_picture2.jpg" alt="image carousel atelier 1830" data-bs-toggle="modal"
                            id="imageHome2" data-bs-target="#modalHome" onclick="ajouterClasseActive('imageHome2')"></li>
                    <li><img src="./images/default_picture3.jpg" alt="image carousel atelier 1830" data-bs-toggle="modal"
                            id="imageHome3" data-bs-target="#modalHome" onclick="ajouterClasseActive('imageHome3')"></li>
                    <li><img src="./images/default_picture4.jpg" alt="image carousel atelier 1830" data-bs-toggle="modal"
                            id="imageHome4" data-bs-target="#modalHome" onclick="ajouterClasseActive('imageHome4')"></li>
                    <li><img src="./images/default_picture5.jpg" alt="image carousel atelier 1830" data-bs-toggle="modal"
                            id="imageHome5" data-bs-target="#modalHome" onclick="ajouterClasseActive('imageHome5')"></li>
                    <li><img src="./images/default_picture6.jpg" alt="image carousel atelier 1830" data-bs-toggle="modal"
                            id="imageHome6" data-bs-target="#modalHome" onclick="ajouterClasseActive('imageHome6')"></li>
                    <li><img src="./images/default_picture8.jpg" alt="image carousel atelier 1830" data-bs-toggle="modal"
                            id="imageHome8" data-bs-target="#modalHome" onclick="ajouterClasseActive('imageHome8')"></li>
                    <li><img src="./images/default_picture9.jpg" alt="image carousel atelier 1830" data-bs-toggle="modal"
                            id="imageHome9" data-bs-target="#modalHome" onclick="ajouterClasseActive('imageHome9')"></li>
                </ul>
            </div>



            <!-- Modal -->
            <div class="modal fade" id="modalHome" tabindex="-1" aria-labelledby="modalHomeLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div id="homeIndicators" class="carousel slide mx-auto">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="carousel-inner">
                                    @for ($i = 1; $i < 7; $i++)
                                        <div class="carousel-item" id="imageHome{{ $i }}_home">
                                            <img src="{{ asset('./images/default_picture' . $i . '.jpg') }}"
                                                alt="image carousel atelier 1830" style="width: 100%">
                                        </div>
                                    @endfor
                                    @for ($i = 8; $i < 10; $i++)
                                        <div class="carousel-item" id="imageHome{{ $i }}_home">
                                            <img src="{{ asset('./images/default_picture' . $i . '.jpg') }}"
                                                alt="image carousel atelier 1830" style="width: 100%">
                                        </div>
                                    @endfor
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#homeIndicators"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#homeIndicators"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <!-- **************** FIN CARROUSSEL **************** -->




            <div class="container bloc_l1">
                <div class="row p-0 m-0 text-center">
                    <h1>Qui sommes-nous ?</h1>
                </div>
                <div class="row p-0 m-0">
                    <div class="col-md-6 mt-5 col-lg-4 text-center">
                        <div class="article_header img1">
                            <h3>Mon Entreprise</h3>
                            <p>Atelier 1830 est une entreprise de tapisserie en décoration. Le
                                savoir-faire artisanal de cette enseigne révèle une qualité de travail remarquable.
                                Fidèle,
                                l'atelier ne manque pas de satisfaire ses clients par sa précision et son application dans
                                ses travaux.
                            </p>
                            <span data-bs-toggle="modal" data-bs-target="#modalRoundImg"><img
                                    src="./images/IMG_header/couture_coussin_cuir.webp" alt="coussin noir et blanc"
                                    id="img1" width="130px" height="130px">
                            </span>

                            <!-- Modal -->
                            <div class="modal fade" id="modalRoundImg" tabindex="-1"
                                aria-labelledby="modalRoundImgLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="">
                                            <img src="./images/couture_coussin_cuir.jpg" alt="coussin noir et blanc"
                                                style="width: 100%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-5 col-lg-4 text-center">
                        <div class="article_header img2">
                            <h3>Les activités de l'atelier</h3>
                            <p>Passionné, l'atelier confectionne dans les règles de l'art des rideaux, voilages, housses
                                de canapés et chaises, des coussins, des stores bateau, des galettes de mousses, etc...<br>
                                Chaque client propose ses idées (tissus, couleurs,... )
                                et nous travaillons ensemble la réalisation du projet.</p>
                            <span data-bs-toggle="modal" data-bs-target="#modalRoundImg2"><img
                                    src="./images/IMG_header/Draps_header.webp" alt="draps" id="img2"
                                    width="130px" height="130px">
                            </span>

                            <!-- Modal -->
                            <div class="modal fade" id="modalRoundImg2" tabindex="-1"
                                aria-labelledby="modalRoundImg2Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="">
                                            <img src="./images/default_picture11.jpg" alt="draps"
                                                style="width: 100%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-5 col-lg-4 text-center">
                        <div class="article_header img3">
                            <h3>Pourquoi 1830 ?</h3>
                            <p>Un peu d'histoire : en 1830, M Barthélémy Thimonnier invente le premier métier à coudre
                                qui
                                peut enchaîner jusqu'à 200 points par minute. Rassurez vous, l'atelier travaille sur une
                                machine encore plus performante, qui se caractérise par sa rapidité et sa précision.</p>
                            <span data-bs-toggle="modal" data-bs-target="#modalRoundImg3"><img
                                    src="./images/IMG_header/machineacoudre_thimonnier_header.webp"
                                    alt="première machine à coudre" id="img3" width="130px" height="130px">
                            </span>

                            <!-- Modal -->
                            <div class="modal fade" id="modalRoundImg3" tabindex="-1"
                                aria-labelledby="modalRoundImg3Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="">
                                            <img src="./images/machineacoudre_thimonnier.jpg"
                                                alt="première machine à coudre" style="width: 75%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 img_mac_header_tab text-center">
                        <img src="./images/machineacoudre_thimonnier.jpg" alt="première machine à coudre">
                    </div>
                </div>
            </div>
        </header>



        <!-- **************** A PROPOS DE VOTRE ARTISAN **************** -->
        <section id="info_artisan">
            <h2>&#192; propos de votre Artisan</h2>
            <div class="container">
                <div class="row p-0 m-0 bloc text-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="bloc_info">
                            <h3>Son Parcours</h3>
                            <p>Formée par des maîtres d'apprentissage très exigeants, je suis diplômée du CFA <strong>La
                                    Bonne Graine</strong> à Paris et ai obtenu mon CAP en alternance au sein de la
                                capitale.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="bloc_info">
                            <h3>Artisan d'Art</h3>
                            <p>Tapissière au savoir-faire artisanal reconnu.</p>
                            <img src="./images/logo-artisan-art.jpg" alt="logo artisan d'art atelier 1830">
                        </div>
                    </div>
                </div>
                <div class="row p-0 m-0 bloc text-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="bloc_info_loc">
                            <h3>Localisation</h3>
                            <img src="{{ asset('./images/logos/location.png') }}"
                                alt="logo situation géographique atelier 1830">
                            <p>L'atelier se situe à Versailles <strong>(78)</strong>. Prenez contact via notre <a
                                    href="{{ route('contact') }}">formulaire</a> ou par <a
                                    href="tel:+330649587935">téléphone</a>/<a
                                    href="mailto:sophievicari@gmail.com">mail</a> si vous
                                souhaitez
                                obtenir
                                des renseignements.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <script>
            const root = document.documentElement;
            const marqueeElementsDisplayed = getComputedStyle(root).getPropertyValue("--marquee-elements-displayed");
            const marqueeContent = document.querySelector("ul.marquee-content");

            root.style.setProperty("--marquee-elements", marqueeContent.children.length);

            for (let i = 0; i < marqueeElementsDisplayed; i++) {
                marqueeContent.appendChild(marqueeContent.children[i].cloneNode(true));
            }



            // *******************************************
            // JavaScript pour le carousel de la page home
            // *******************************************
            var homeModal = document.getElementById('modalHome');
            var homeCarousel = document.getElementById('homeIndicators');

            homeModal.addEventListener('hidden.bs.modal', function() {
                // Supprimez la classe active de l'élément du carousel lorsque le modal est fermé
                var activeItem = homeCarousel.querySelector('.carousel-item.active');
                console.log(activeItem)
                if (activeItem) {
                    activeItem.classList.remove('active');
                }
            });

            function ajouterClasseActive(element) {
                element += '_home';
                // Récupère l'élément cliqué
                const elementClique = document.getElementById(element);

                // Ajoute la classe active à l'élément
                elementClique.classList.add("active");
                console.log(element);
            }
        </script>
    </div>
@endsection
