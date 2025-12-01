<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use App\Rules\ImageUrl;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // DEPRECATED METHOD FOR LOADING FEED
    public function index()
    {
        $users = User::all();
        return view('admin.users', ['users'=>$users]);
    }

    // DEPRECATED METHOD FOR LOADING FEED
    public function details(User $user)
    {
        return view('users.details', ['user'=>$user]);
    }

    // DEPRECATED METHOD FOR LOADING FEED
    public function update(User $user)
    {
        return view('users.update', ['user'=>$user]);
    }

    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'username'      => 'required|string|max:40',
            'first_name'    => 'nullable|string|max:40',
            'last_name'     => 'nullable|string|max:40',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'nullable|string|min:8|confirmed', // password is optional
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
    Public function destroy(User $user)
    {
        $user->delete();
        return redirect()
            ->route('admin.users')
            ->with('message','User deleted');
    }



    // Method loads posts either from all users (the feed)
    // or from a single user (a profile)
    // depending on the route used (and whether a user is provided)
    public function user_stats(User $user)
    {
        $postMetrics = [
            'Top Heard Post'    => $user->top_heard_post,
            'Top Clapped Post'  => $user->top_clapped_post,
            'Top Echoed Post'   => $user->top_echoed_post];
        $commentMetrics = [
            'Top Heard Comment'     => $user->top_heard_comment,
            'Top Clapped Comment'   => $user->top_clapped_comment];

        return view('users.stats',
            [
                'postMetrics' => $postMetrics,
                'commentMetrics' => $commentMetrics
            ]);
    }

    public function all_user_stats()
    {
        $users = User::withCount(['posts', 'comments'])
                ->get();

        return view('admin.stats', ['users' => $users]);
    }
}
