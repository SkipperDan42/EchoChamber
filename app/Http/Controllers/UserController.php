<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Rules\ImageUrl;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // DEPRECATED METHOD FOR LOADING FEED
    public function details(User $user)
    {
        return view('users.details', ['user'=>$user]);
    }

    // DEPRECATED METHOD FOR LOADING FEED
    public function update(User $user)
    {
        if ($user->id == auth()->user()->id || auth()->user()->administrator_flag) {
            return view('users.update', ['user'=>$user]);
        }
        else {
            return redirect()
                ->route('user.details', ['user'=>$user])
                ->with('danger', 'You may not update this user!');
        }
    }

    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->update($validated);

        return redirect()
            ->route('user.details', $user)
            ->with('message', 'User updated successfully.');
    }


    /**
     * ...
     * @return \Illuminate\Http\RedirectResponse
     */
    Public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')
            ->with('message','Post deleted');
    }
}
