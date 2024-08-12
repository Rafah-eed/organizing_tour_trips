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
        // Check if a user is authenticated
        if (!Auth::check()) {
            // No user is logged in, return an unauthorized response
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Retrieve the authenticated user
        $user = Auth::user();


        if ($user->isGuide()) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized 403'], 403);
    }


}
