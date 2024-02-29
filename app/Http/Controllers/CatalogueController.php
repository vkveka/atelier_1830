<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $catalogues = Catalogue::orderBy('created_at', 'desc')->get();

        return view('pages/catalogue', [
            'catalogues' => $catalogues,
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
    public function store(Request $request, Catalogue $catalogue)
    {
        $request->validate([
            'image' => 'required|max:10000',
            'title' => 'required|max:200',
        ]);

        $catalogue->create([
            'image' => $_FILES['image']['name'],
            'title' => $request->title,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move('./images', $imageName);
        }

        return redirect()->route('admin')->with('message', 'Une image a été ajoutée au catalogue.');
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
    public function update(Request $request, Catalogue $catalogue)
    {
        $request->validate([
            'newTilte' => 'required|max:200',
        ]);

        $catalogue->update([
            'title' => $request->newTilte,
        ]);

        return redirect()->route('admin')->with('message', 'L\'image a été modifiée.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalogue $catalogue)
    {
        $catalogue->delete();
        return redirect()->route('admin')->with('message', 'L\'image a été supprimée du catalogue');
    }
}
