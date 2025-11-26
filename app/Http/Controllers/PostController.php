<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Rules\ImageUrl;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // DEPRECATED METHOD FOR LOADING FEED
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

    // DEPRECATED METHOD FOR LOADING PROFILE
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

    // Method loads posts either from all users (the feed)
    // or from a single user (a profile)
    // depending on the route used (and whether a user is provided)
    public function posts(?User $user = null)
    {
        // If not a user profile, show feed
        if ($user === null) {
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
        }

        // If a specific user profile, show only user posts
        else {
            // Get all posts belonging to a user and comments preloaded. Paginate them to simplify loading
            $posts = Post::with(['user', 'comments'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        // Get the users of all echoed posts
        $echoedIds = $posts
            ->pluck('echoed')
            ->filter()
            ->unique();
        $echoedPosts = Post::with('user')
            ->whereIn('id', $echoedIds)
            ->get()
            ->keyBy('id');

        return view('posts.index',
                    ['posts'=>$posts,
                    'echoedPosts'=>$echoedPosts,
                    'profileUser' => $user,
                    ]);
    }

    public function show(Post $post)
    {
        $echoedPost = Post::with('user')
            ->where('id', $post->echoed)
            ->first();

        return view('posts.show',
            ['post'=>$post,
            'echoedPost'=>$echoedPost,
            'profileUser' => $post->user
            ]);
    }

    public function create()
    {
        return $this->edit(null);
    }


    public function edit(Post $post)
    {
        return view('posts.create', ['post'=>$post]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form fields
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string|max:7000',
            'media' => ['nullable', 'url', new ImageUrl, 'max:255'],
            'id'    => 'nullable|integer|exists:posts,id', // Hidden for edits only
        ]);

        // Check if id is empty (i.e. if post is being edited)
        if (!empty($validatedData['id'])) {
            $original_post = Post::findOrFail($validatedData['id']);

            // Edit if authenticated user owns the post
            if ($original_post->user_id == auth()->id()) {
                $post = $original_post;
            }
            // Echo if authenticated user does not own the post
            else {
                $post = new Post();
                $post->user_id = auth()->id();
                $post->heard = 0;
                $post->echoed = $original_post->user_id;
                $post->echoes = 0;
                $post->claps = 0;
            }
        }
        // Else create new post
        else {

            $post = new Post();
            $post->user_id = auth()->id();
            $post->heard = 0;
            $post->echoed = null;
            $post->echoes = 0;
            $post->claps = 0;
        }

        // Set filled form fields
        $post->title   = $validatedData['title'];
        $post->content = $validatedData['content'] ?? null;
        $post->media   = $validatedData['media'] ?? null;
        $post->save();

        // Success confirmation and redirect
        session()->flash('message', $validatedData['id'] ? 'Post updated' : 'Posted');
        return redirect()->route('posts.feed');
    }

    // Add a clap
    public function clap(Post $post)
    {
        $post->increment('claps');
        return back();
    }

    // Remove a clap
    public function unclap(Post $post)
    {
        $post->decrement('claps');
        return back();
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
