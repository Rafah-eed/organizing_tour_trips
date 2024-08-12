<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Check if a user is authenticated
        if (!Auth::check()) {
            // No user is logged in, return an unauthorized response
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Retrieve the authenticated user
        $user = Auth::user();

        // Use the isAdmin method to check if the user is an admin
        if ($user->isAdmin()) {
            // The user is an admin, proceed with the request
            return $next($request);
        }

        // The user is not an admin, return an unauthorized response
        return response()->json(['error' => 'Unauthorized'], 403);
    }


}
