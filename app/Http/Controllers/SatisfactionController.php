<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Database\Seeders\SatisfactionSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SatisfactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('pages/satisfaction');
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
        $product = Product::find($request->productId);
        $product->satisfactions()->attach(Auth::user()->id, ['note' => $request->rating]);

        return redirect()->route('gammes.index')->with('message', 'A voté !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, $satisfaction)
    {
        $product = Product::find($request->productId);

        // Détacher la satisfaction en utilisant l'ID de la satisfaction à supprimer
        $product->satisfactions()->detach($satisfaction);

        return redirect()->route('gammes.index')->with('message', 'Satisfaction supprimée !');
    }
}
