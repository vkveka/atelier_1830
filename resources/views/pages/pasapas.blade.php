@extends('layouts.app')

@section('title')
    Pas à Pas | Atelier 1830
@endsection


@section('content')
    <section id="pasapas">
        

        <div class="section1 pb-5">

            <div class="row row_carousel_pasapas">
                <div class="col-lg-4 col-md-5 offset-lg-1 offset-0 my-auto ps-md-5 p-5">
                    <h2>Pour confectionner un élément de décors, il y a plusieurs étapes</h2>
                </div>
                <div id="carouselExampleDark"
                    class="carousel carousel-dark slide carousel-fade col-lg-4 col-md-5 col-sm-8 col-10 offset-md-1 my-auto mx-auto"
                    data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3"
                            aria-label="Slide 4"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="4"
                            aria-label="Slide 4"></button>


                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="3000">
                            <div class="carousel-caption">
                                <h5>Développé sur papier kraft</h5>
                            </div>
                            <img src="{{ asset('./images/pasapas/IMG-20191113-WA0002.jpg') }}" class="d-block w-100"
                                alt="images pas à pas">
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="{{ asset('./images/pasapas/IMG-20191121-WA0009.jpg') }}" class="d-block w-100"
                                alt="images pas à pas">
                            <div class="carousel-caption">
                                <h5>Calcul de métrage puis choix des matières premières</h5>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="{{ asset('./images/pasapas/IMG-20191121-WA0017.jpg') }}" class="d-block w-100"
                                alt="images pas à pas">
                            <div class="carousel-caption">
                                <h5>Découpe doublure puis tissu</h5>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="{{ asset('./images/pasapas/20191121_162611.jpg') }}" class="d-block w-100"
                                alt="images pas à pas">
                            <div class="carousel-caption">
                                <h5>Assemblage</h5>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="{{ asset('./images/pasapas/20191201_113609.jpg') }}" class="d-block w-100"
                                alt="images pas à pas">
                            <div class="carousel-caption">
                                <h5>Pose passementerie</h5>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="section2 pt-5">

            <div class="row row_carousel_pasapas d-flex justify-content-around">

                <div id="carouselExampleDark2"
                    class="carousel carousel-dark slide carousel-fade col-lg-4 col-md-5 col-8 my-auto"
                    data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark2" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark2" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleDark2" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#carouselExampleDark2" data-bs-slide-to="3"
                            aria-label="Slide 4"></button>
                        <button type="button" data-bs-target="#carouselExampleDark2" data-bs-slide-to="4"
                            aria-label="Slide 4"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="3000">
                            <img src="{{ asset('./images/pasapas/20201123_141117.jpg') }}" class="d-block w-100"
                                alt="images pas à pas">
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="{{ asset('./images/pasapas/20201123_141130.jpg') }}" class="d-block w-100"
                                alt="images pas à pas">
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="{{ asset('./images/pasapas/20201123_141140.jpg') }}" class="d-block w-100"
                                alt="images pas à pas">
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="{{ asset('./images/pasapas/20201123_141152.jpg') }}" class="d-block w-100"
                                alt="images pas à pas">
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="{{ asset('./images/pasapas/20201123_141239_2.jpg') }}" class="d-block w-100"
                                alt="images pas à pas">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark2"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark2"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="col-lg-4 col-md-5 my-auto">
                    <h2>De telles réalisations demandent beaucoup de précision et celle-ci a été pour Atelier 1830 le fruit
                        de longues heures de dessin technique et de dessin d'art, au millimètre près.</h2>
                </div>
            </div>
        </div>
      





    </section>
@endsection
