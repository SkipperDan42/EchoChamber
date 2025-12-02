<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Rules\ImageUrl;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Method loads posts either from all users (the feed)
    // or from a single user (a profile)
    // depending on the route used (and whether a user is provided)
    public function comments(User $user)
    {

        // Get all comments belonging to a user and post preloaded. Paginate them to simplify loading
        $comments = Comment::with(['user', 'post'])
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('comments.index',
            [
                'comments'=>$comments,
                'profileUser' => $user,
            ]);
    }

    public function create()
    {
        return $this->edit();
    }


    public function edit(?Comment $comment = null)
    {
        return view('comments.create', ['comment'=>$comment]);
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
            'content' => 'nullable|string|max:7000',
            'user_id'   => 'required|integer|exists:users,id',
            'post_id' => 'required|integer|exists:posts,id',
            'id'    => 'nullable|integer|exists:comments,id', // Hidden for edits only
        ]);

        // Check if id is empty and edit if authenticated user owns the comment
        if (!empty($validatedData['id'])) {
            $comment = Comment::findOrFail($validatedData['id']);
        }
        // Else create new comment
        else {

            $comment = new Comment();
            $comment->user_id = $validatedData['user_id'];
            $comment->post_id = $validatedData['post_id'];
            $comment->heard = 0;
            $comment->claps = 0;
        }

        // Set filled form fields
        $comment->content = $validatedData['content'];
        $comment->save();

        // Success confirmation and redirect
        session()->flash('message', $comment->id ? 'Comment updated' : 'Commented');
        return redirect()->route('posts.show', $comment->post_id);
    }

    // Add a clap
    public function clap(Comment $comment)
    {
        $comment->claps()->toggle(auth()->user()->id);
        $comment->claps = $comment->claps()->count();
        $comment->save();

        return back();
    }


    /**
     * ...
     * @return \Illuminate\Http\RedirectResponse
     */
    Public function destroy(Comment $comment)
    {
        $post = $comment->post->id;
        $comment->delete();
        return redirect()
            ->route('posts.show', ['post'=>$post])
            ->with('danger','Comment deleted');
    }
}
