<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Returns Admin view with all Users
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users', ['users'=>$users]);
    }

    /**
     * Returns User view with all User details
     */
    public function details(User $user)
    {
        return view('users.details', ['user'=>$user]);
    }

    /**
     * Returns view to update User details
     */
    public function update(User $user)
    {
        return view('users.update', ['user'=>$user]);
    }

    /**
     * Stores a new or updated user
     */
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
     * Destroys a User
     * Reroutes to Admin User view for an Admin, will automatically log-out User if they deleted themselves
     */
    Public function destroy(User $user)
    {
        $user->delete();
        return redirect()
            ->route('admin.users')
            ->with('message','User deleted');
    }


    /**
     * Loads User stats metrics and returns them to User stats view
     */
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

    /**
     * Loads Users with Posts and Comments for Admin stats view
     */
    public function all_user_stats()
    {
        $users = User::withCount(['posts', 'comments'])
                ->get();

        return view('admin.stats', ['users' => $users]);
    }
}
