<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $nbComments = Comment::count();
        $comments = Comment::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('comments/index', [
            'comments' => $comments,
            'nbComments' => $nbComments,
        ]);
    }

    public function store(Request $request, Comment $comment)
    {
        $request->validate([
            'title' => 'required|max:80',
            'note' => 'required',
            'content' => 'nullable|string',
        ]);

        $comment->create([
            'title' => $request->title,
            'note' => $request->note,
            'content' => $request->content,
            'user_id' => Auth::user()->id,
        ]);


        return redirect()->back()->with('message', 'Un commentaire a été ajouté');
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
    public function destroy(Comment $comment)
    {
        //
        $comment->delete();
        return redirect()->route('admin')->with('message', 'Le commentaire a bien été supprimé');
    }
}
