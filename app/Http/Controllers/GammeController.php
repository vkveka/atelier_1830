<?php

namespace App\Http\Controllers;

use App\Models\Gamme;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GammeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //EAGER LOADING
        // avec les produits et leur satisfactions
        $gammes = Gamme::with('products.satisfactions')->get();

        // récupère les produits qui ont une satisfaction 
        $products = Product::has('satisfactions')->get();
        //renvoie une vue et injecte une variable dedans
        return view('gammes/index', [
            'gammes' => $gammes,
            'products' => $products
        ]);
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
        $request->validate([
            'name' => 'required|max:40',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000', // Ajustez les types de fichiers et la taille selon vos besoins
        ]);

        // Vérifiez s'il y a une nouvelle image téléchargée
        if ($request->hasFile('image')) {
            $newImage = $request->file('image');
            $imageName = $newImage->getClientOriginalName();
            $newImage->move('./images', $imageName);

            // Créez une nouvelle gamme en incluant le nom de l'image dans la base de données
            Gamme::create([
                'name' => $request->name,
                'image' => $imageName,
            ]);
        } else {
            // Si aucune nouvelle image n'a été téléchargée, créez la gamme sans le champ image
            Gamme::create([
                'name' => $request->name,
            ]);
        }

        return redirect()->route('admin')->with('message', 'Une gamme a été ajoutée');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function update(Request $request, Gamme $gamme)
    {
        $request->validate([
            'name' => 'required|max:40',
            'newImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048', // Ajustez les types de fichiers et la taille selon vos besoins
        ]);

        // Vérifiez s'il y a une nouvelle image téléchargée
        if ($request->hasFile('newImage')) {
            $newImage = $request->file('newImage');
            $imageName = $newImage->getClientOriginalName();
            $newImage->move('./images', $imageName);

            // Mettez à jour le nom de l'image dans la base de données
            $gamme->image = $imageName;
        }

        // Mettez à jour les autres champs
        $gamme->name = $request->name;
        $gamme->save();

        return redirect()->route('admin')->with('message', 'La gamme a bien été modifiée');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gamme $gamme)
    {
        $gamme->delete();

        return redirect()->route('admin')->with('message', 'La gamme a bien été supprimée');
    }
}
