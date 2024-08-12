<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckGuideRole
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
        if (Auth::check()) {
            // Retrieve the raw original value of the role attribute
            $role = Auth::user()->getRawOriginal('role');

            // Check if the user's role is 'admin'
            if ($role === 'guide') {
                // The user is an admin, proceed with the request
                return $next($request);
            }
        }

        // The user is not an admin or not authenticated, return an unauthorized response
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
