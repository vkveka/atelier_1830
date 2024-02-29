@extends('layouts.app')

@section('title')
    Gammes
@endsection


@section('content')
    <section id="commandes">
        <div class="container-fluid mb-4">
            <div class="card mx-auto my-5">
                <div class="card-header pt-3">
                    <h3>Commandes n° <b>{{ $commandes->numero }}</b></h3>
                    <h3>Date :
                        <b>@php
                            echo \Carbon\Carbon::parse($commandes->created_at)->translatedFormat('l d F Y à H\hi');
                        @endphp</b>
                    </h3>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Description</th>
                            <th scope="col">Aperçu</th>
                            <th scope="col">Prix U.</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Prix total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commandes->products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->desc }}</td>
                                <td><img src="{{ asset('./images/' . $product->image) }}" alt="photo du produit"
                                        style="width: 4em"></td>
                                <td>{{ $product->price }}€</td>
                                <td>{{ $product->pivot->quantity }}</td>
                                <td>{{ $product->price * $product->pivot->quantity }}€</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
