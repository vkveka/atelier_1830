<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // je crée la commande (pour le moment sans ses infos)
        $commande = new Commande;

        // je lui attribue ses informations 
        $commande->numero = rand(100000, 999999);
        $commande->price = $request->input('lastTotal');
        $commande->user_id = auth()->user()->id;
        $commande->pickup_date = date('Y-m-d', strtotime('+1 month'));

        // je la sauvegarde en bdd
        $commande->save();

        // je récupère le panier (stocké dans une variable), et je boucle dessus
        $panier = session()->get("cart");

        foreach ($panier as $product) {

            // j'insère chacun de ses articles dans commande_articles (syntaxe attach)
            $commande->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        // je redirige vers une route qui vide le panier puis qui charge l'accueil
        return redirect()->route('cart.emptyAfterOrder');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        // je charcge les articles de la commande
        $commande->load('products');

        // je renvoie la vue commande/show pour afficher son détail
        return view('commandes/show', ['commandes' => $commande]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        $commande->delete();
        return redirect()->route('admin')->with('message', 'La commande a bien été supprimée');
    }
}
