<?php

namespace App\Http\Controllers;

use App\Models\Asking;
use Illuminate\Http\Request;

class AskingController extends Controller
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
    public function store(Request $request, Asking $asking)
    {
        $request->validate([
            'firstname' => 'required|max:40',
            'lastname' => 'required|max:40',
            'content' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
        ]);

        $asking->create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'content' => $request->content,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);


        return redirect()->back()->with('message', 'Votre message a été envoyé, nous vous recontacterons.');
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
    public function update(Request $request, Asking $asking)
    {
        $request->validate([
            'status' => 'int',
        ]);

        if ($request->status === null) {
            $status = 0;
        } else {
            $status = $request->status;
        }

        $asking->update([
            'status' => $status,
        ]);

        return redirect()->back()->with('message', 'Le status a été modifié.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
