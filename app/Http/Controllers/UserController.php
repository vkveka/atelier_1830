<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class UserController extends Controller
{
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
    public function edit(User $user)
    {
        if (Auth::user()) {
            $user->load('commandes');

            // $userSatisfactions = Auth::user()->satisfactions->pluck('id');
            // Récupérer les produits associés aux satisfactions de l'utilisateur
            // $products = Product::whereIn('id', $userSatisfactions)->get();

            return view('user/edit', [
                'user' => $user,
                // 'products' => $products,
            ]);
        } else {
            abort(404, 'PAGE NON TROUVEE');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $request->validate([
            'firstname' => 'required|max:40',
            'lastname' => 'nullable|string',
            'email' => 'string',
            'password' => [
                'nullable', 'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
        ]);

        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
        ]);

        if ($request->password) {
            if ($request->oldPassword && Hash::check($request->oldPassword, User::find($user->id)->password)) {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
            } else {
                return redirect()->back()->withErrors(['erreur' => 'L\'ancien mot de passe est incorrect']);
            }
        }

        return redirect()->route('users.edit', $user)->with('message', 'Le compte a bien été modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // $user = User::find(auth()->user()->id);
        // $user = User::find(Auth::user()->id);

        if (Auth::user()->id == $user->id || Auth::user()->role_id == 1) {
            $user->delete();
            return redirect()->route('home')->with('message', 'Le compte a bien été supprimé');
        } else {
            return redirect()->back()->withErrors(['erreur' => 'suppression du compte impossible']);
        }
    }

    public function ban(User $user)
    {
        $user->update([
            'role_id' => 3,
        ]);

        return redirect()->route('admin')->with('message', 'L\'utilisateur a été banni');
    }
}
