<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Rules\ImageUrl;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function feed()
    {
        //dd($projects);

        // Get all posts with their users and comments preloaded. Paginate them to simplify loading
        // !! NOTE that this uses the reddit trending algorithm as an SQLite query !!
        // !! THIS QUERY WAS SOURCED FROM CHATGPT !!
        $posts = Post::with(['user', 'comments'])
                    ->selectRaw('
                                posts.*,
                                claps * 1.0 /
                                POWER(
                                    ((strftime("%s", "now") - strftime("%s", created_at)) / 3600) + 2,
                                    1.5)
                                AS trending_score')
                    ->orderBy('trending_score', 'desc')
                    ->paginate(5);

        // Get the users of all echoed posts
        $echoedIds = $posts
                        ->pluck('echoed')
                        ->filter()
                        ->unique();
        $echoedPosts = Post::with('user')
                        ->whereIn('id', $echoedIds)
                        ->get()
                        ->keyBy('id');

        return view('posts.feed', ['posts'=>$posts, 'echoedPosts'=>$echoedPosts]);
    }

    //
    public function profile(User $user)
    {

        // Get all posts belonging to a user and comments preloaded. Paginate them to simplify loading
        $posts = Post::with(['user', 'comments'])
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);

        // Get the users of all echoed posts
        $echoedIds = $posts
                    ->pluck('echoed')
                    ->filter()
                    ->unique();
        $echoedPosts = Post::with('user')
                        ->whereIn('id', $echoedIds)
                        ->get()
                        ->keyBy('id');

        return view('posts.profile', ['posts'=>$posts, 'echoedPosts'=>$echoedPosts]);
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
