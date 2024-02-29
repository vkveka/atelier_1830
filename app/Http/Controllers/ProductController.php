<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


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
     * Display a listing of the resource.
     *
       * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::all();
        return view('cart/show', [
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:40',
            'desc' => 'required',
            'full_desc' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10000', // Ajustez les types de fichiers et la taille selon vos besoins
            'price' => 'nullable',
            'dispo' => 'required',
            'gamme_id' => 'required',
        ]);

        // Vérifiez s'il y a une image téléchargée
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move('./images', $imageName);

            // Créez un nouveau produit en incluant le nom de l'image dans la base de données
            $product->create([
                'name' => $request->name,
                'image' => $imageName,
                'desc' => $request->desc,
                'full_desc' => $request->full_desc,
                'price' => $request->price,
                'dispo' => $request->dispo,
                'gamme_id' => $request->gamme_id,
            ]);
        }

        return redirect()->route('admin')->with('message', 'Un produit a été ajouté');
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
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:40',
            'desc' => 'required',
            'full_desc' => 'required|max:1000',
            'price' => 'required',
            'dispo' => 'required',
            'gamme_id' => 'required',
        ]);

        // Vérifiez s'il y a un nouveau fichier d'image téléchargé
        if ($request->hasFile('newImage')) {
            // Validez et stockez le nouveau fichier d'image
            $request->validate([
                'newImage' => 'image|mimes:jpeg,png,jpg,gif|max:4048', // ajustez les types de fichiers et la taille selon vos besoins
            ]);

            $newImage = $request->file('newImage');
            $imageName = $newImage->getClientOriginalName();
            $newImage->move('./images', $imageName);

            // Mettez à jour le nom de l'image dans la base de données
            $product->image = $imageName;
        }


        // Mettez à jour les autres champs
        $product->name = $request->name;
        $product->desc = $request->desc;
        $product->full_desc = $request->full_desc;
        $product->price = $request->price;
        $product->dispo = $request->dispo;
        $product->gamme_id = $request->gamme_id;

        $product->save();

        return redirect()->route('admin')->with('message', 'Modification du produit réussie');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin')->with('message', 'Le produit a été supprimé');
    }
}
