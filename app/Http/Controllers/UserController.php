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
                ->route('users.details', ['user'=>$user])
                ->with('danger', 'You may not update this user!');
        }
    }

    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password'    => 'nullable|string|min:8|confirmed', // password is optional
        ]);

        // Hash the password if entered and validated
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }
        // Don't update password if left blank
        else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.details', $user)
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
