<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Rules\ImageUrl;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show(Post $post)
    {
        $post->load('comments');
        return view('posts.show', ['post'=>$post]);
    }

    public function create()
    {
        return view('comments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'nullable|string|max:7000',  // Roughly 1000 words
            'heard' => 'required|integer',
            'claps' => 'required|integer'
        ]);

        $a = new Comment();
        $a->content = $validatedData['content'];
        $a->heard = $validatedData['heard'];
        $a->claps = $validatedData['claps'];
        $a->save();

        session()->flash('message','Commented');
        return redirect()->route('posts.show',['post'=>$a]);
    }


    /**
     * ...
     * @return \Illuminate\Http\RedirectResponse
     */
    Public function destroy(Comment $comment)
    {
        $post_id = $comment->post_id;

        $comment->delete();
        return redirect()
            ->route('posts.show',['post'=>$post_id])
            ->with('message','Comment deleted');
    }
}
