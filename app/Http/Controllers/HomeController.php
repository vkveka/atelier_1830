<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Catalogue;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    //oblige la connection pour accéder à toutes les fonctions de ce Controller
    // public function __construct()
    // {
    //     $this->middleware('auth'); 
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function contact()
    {
        return view('pages/contact');
    }

    public function pasapas()
    {
        $products = Product::all();

        return view('pages/pasapas', [
            'products' => $products,
        ]);
    }

    public function politiques()
    {
        return view('pages/politiques');
    }
}
