<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CartController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            return view("cart.show"); // resources\views\cart\show.blade.php
        } else {
            return redirect("login");
        }
    }


    public function add($productId, Request $request)
    {
        // Validation de la requête
        $this->validate($request, [
            "quantity" => "numeric|min:1"
        ]);

        $product = Product::find($productId); // on récupère l'article
        $quantity = $request->quantity; // on récupère la quantité choisie

        // Ajout/Mise à jour du produit au panier avec sa quantité
        $cart = session()->get("cart"); // On récupère le panier en session

        // Les informations du produit à ajouter
        $product_details = [
            'id' => $product->id,
            'name' => $product->name,
            'image' => $product->image,
            'price' => $product->price,
            'desc' => $product->desc,
            'quantity' => $quantity
        ];

        $cart[$product->id] = $product_details; // On ajoute ou on met à jour le produit au panier
        session()->put("cart", $cart); // On enregistre le panier

        // Redirection vers le panier avec un message
        return redirect()->route("cart.show")->withMessage("Produit ajouté au panier");
    }

    // supprimer un article du panier
    public function remove($key)
    {
        // Suppression du produit du panier par son identifiant
        $cart = session()->get("cart"); // On récupère le panier en session
        unset($cart[$key]); // On supprime le produit du tableau $cart
        session()->put("cart", $cart); // On enregistre le panier

        // Redirection vers le panier
        return back()->withMessage("Produit retiré du panier");
    }

    // Vider le panier
    public function empty()
    {
        // Suppression du panier en session
        session()->forget("cart");

        // Redirection 
        return back()->withMessage("Panier vidé");
    }

    public function emptyAfterOrder()
    {
        // Suppression des informations du panier en session
        session()->forget("cart");

        // Redirection
        return redirect('home')->withMessage("Votre commande a été validée. Merci de votre confiance.");
    }

    public function validation(Request $request)
    {
        if (Gate::denies("access_order_validation")) {
            abort(403, 'Vous n\'êtes pas connecté');
        }

        $user = User::find(auth()->user()->id);

        return view('cart/validation', ['user' => $user]);
    }
}
