<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Rules\ImageUrl;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Method loads posts either from all users (the feed)
     * or from a single user (a profile)
     * depending on the route used (and whether a user is provided)
     */
    public function posts(?User $user = null)
    {
        // If not a user profile, show feed
        if ($user === null) {
            // Get all posts with their users and comments preloaded. Paginate them to simplify loading
            // !! NOTE that this uses the reddit trending algorithm as an SQLite query !!
            // !! THIS QUERY IS NOT MY OWN WORK !!
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

        return view('posts.index',
                    [
                        'posts'=>$posts,
                        'profileUser' => $user,
                    ]);
    }

    /**
     * Returns a single Post
     */
    public function show(Post $post)
    {
        return view('posts.show',
            [
                'post'=>$post
            ]);
    }

    /**
     * Create a Post
     * Just calls edit with no Post
     */
    public function create()
    {
        return $this->edit();
    }

    /**
     * Edit a Post
     */
    public function edit(?Post $post = null)
    {
        return view('posts.create', ['post'=>$post]);
    }

    /**
     * Store either a new, edited or echoed Post
     */
    public function store(Request $request)
    {
        // Validate the form fields
        $validatedData = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'nullable|string|max:7000',
            'media'     => ['nullable', 'url', new ImageUrl, 'max:255'],
            'user_id'   => 'required|integer|exists:users,id',
            'id'        => 'nullable|integer|exists:posts,id', // Hidden for edits only
        ]);

        // Check if id is empty (i.e. if post is being edited)
        if (!empty($validatedData['id'])) {
            $original_post = Post::findOrFail($validatedData['id']);

            // Edit if authenticated user owns the post
            if ($original_post->user_id == $validatedData['user_id']) {
                $post = $original_post;
            }
            // Echo if authenticated user does not own the post
            else {
                $post = new Post();
                $post->user_id = $validatedData['user_id'];
                $post->heard = 0;
                $post->echoed = $original_post->user_id;
                $post->echoes = 0;
                $post->claps = 0;
            }
        }
        // Else create new post
        else {

            $post = new Post();
            $post->user_id = $validatedData['user_id'];
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
        return redirect()->route('posts.index');
    }

    /**
     * Add or Remove a clap from a Post
     */
    public function clap(Post $post)
    {
        $post->claps()->toggle(auth()->user()->id);
        $post->claps = $post->claps()->count();
        $post->save();

        return view('posts.show',
            [
                'post'=>$post,
            ]);
    }

    /**
     * Destroy a Post
     */
    Public function destroy(Post $post)
    {
        $post->delete();
        return redirect()
            ->route('posts.index')
            ->with('danger','Post deleted');
    }
}
