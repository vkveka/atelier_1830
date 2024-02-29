@extends('layouts.app')

@section('title')
    Galerie | Atelier 1830
@endsection


@section('content')
    <section id="catalogue">

        @if (Auth::user() && Auth::user()->id === 1)
            <div class="text-end me-5 plus_to_admin">
                <a href="{{ route('admin') }}">
                    <i class="fas fa-plus-circle fa-3x" style="color: #a44a4a"></i>
                </a>
            </div>

            <script>
                gsap.to(".plus_to_admin", {
                    y: -30,
                    duration: 1,
                    repeat: -1,
                    ease: 'bounce',
                    yoyo: true,
                })
            </script>
        @endif

        <h1 class="title_section">Galerie photos</h1>
        <div class="gallery_4 col-lg-8 col-md-10 mx-auto">
            <ul>
                @foreach ($catalogues as $catalogue)
                    <li class="col-md-12 col-5">
                        <!-- Button trigger modal -->
                        <a data-bs-toggle="modal" data-bs-target="#modalGallery" id="image_{{ $catalogue->id }}"
                            onclick="ajouterClasseActive('image_{{ $catalogue->id }}')">
                            <figure>
                                <img src='{{ asset('./images/' . $catalogue->image) }}' alt='galerie photos'>
                                <figcaption>{{ $catalogue->title }}</figcaption>
                            </figure>
                        </a>

                        <script>
                            var modal = document.getElementById('modalGallery');
                            var carousel = document.getElementById('carouselIndicators');
                            if (modal !== null) {
                                modal.addEventListener('hidden.bs.modal', function() {
                                    // Supprimez la classe active de l'élément du carousel lorsque le modal est fermé
                                    var activeItem = carousel.querySelector('.carousel-item.active');
                                    // console.log(activeItem)
                                    if (activeItem) {
                                        activeItem.classList.remove('active');
                                    }
                                });
                            }

                            function ajouterClasseActive(element) {
                                element += '_car';
                                // Récupère l'élément cliqué
                                const elementClique = document.getElementById(element);

                                // Ajoute la classe active à l'élément
                                elementClique.classList.add("active");
                                console.log(element);
                            }
                        </script>

                        <!-- Modal -->
                        <div class="modal fade" id="modalGallery" tabindex="-1" aria-labelledby="modalGalleryLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div id="carouselIndicators" class="carousel slide mx-auto">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="carousel-inner">
                                                @foreach ($catalogues as $imgCatalogue)
                                                    <div class="carousel-item " id="image_{{ $imgCatalogue->id }}_car">
                                                        <img src="{{ asset('./images/' . $imgCatalogue->image) }}"
                                                            alt="image du catalogue Atelier 1830" class="mx-auto">
                                                        <div class="carousel-caption">
                                                            <h5>{{ $imgCatalogue->title }}</h5>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#carouselIndicators" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#carouselIndicators" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

    </section>
@endsection
