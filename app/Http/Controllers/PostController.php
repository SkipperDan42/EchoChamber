<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Rules\ImageUrl;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function feed()
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(5);
        //dd($projects);
        return view('posts.feed', ['posts'=>$posts]);
    }

    public function show(Post $post)
    {
        return view('posts.show', ['post'=>$post]);
    }

    public function create()
    {
        return view('posts.create');
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
            'title' => 'required|string|max:255',  // Must be short
            'content' => 'nullable|string|max:7000',  // Roughly 1000 words
            'media' => ['nullable', 'url', new ImageUrl, 'max:255'],  // URL must point to a valid Image
            'heard' => 'required|integer',
            'echoed' => 'required|integer|exists:posts,id', // Must reference a post upon creation
            'echoes' => 'required|integer',
            'claps' => 'required|integer'
        ]);

        $a = new Post();
        $a->title = $validatedData['title'];
        $a->content = $validatedData['content'];
        $a->media = $validatedData['media'];
        $a->heard = $validatedData['heard'];
        $a->echoed = $validatedData['echoed'];
        $a->echoes = $validatedData['echoes'];
        $a->claps = $validatedData['claps'];
        $a->save();

        session()->flash('message','Posted');
        return redirect()->route('posts.feed');
    }


    /**
     * ...
     * @return \Illuminate\Http\RedirectResponse
     */
    Public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.feed')
            ->with('message','Post deleted');
    }
}
