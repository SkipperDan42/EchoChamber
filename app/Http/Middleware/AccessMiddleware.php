<?php

namespace App\Http\Middleware;

use App\Models\Post;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessMiddleware
{
    /**
     * Ensures that the User accessing this root is either an Admin or owns the Page
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth = auth()->user();

        // If not authenticated then fail
        // (not strictly needed as 'auth' middleware should always be called first)
        if (!$auth) {
            return redirect()
                ->back()
                ->with('danger', 'You do not have access to this page.');
        }

        // Admin can always access
        if ($auth->administrator_flag) {
            return $next($request);
        }

        // Loop through possible parameters
        foreach ($request->route()->parameters() as $parameter) {

            // If parameter is User
            if ($parameter instanceof User) {
                if ($auth->id === $parameter->id) {
                    return $next($request);
                }
            }

            // If parameter is Post
            if ($parameter instanceof Post) {
                if ($auth->id === $parameter->user_id) {
                    return $next($request);
                }
            }
        }

        // If all fails
        return redirect()
            ->back()
            ->with('danger', 'You do not have access to this page.');
    }
}
