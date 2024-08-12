<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import Log facade

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
        if (Auth::check()) {
            // Retrieve the raw original value of the role attribute
            $role = Auth::user()->getRawOriginal('role');

            // Log the role to see what value is being retrieved
            Log::info("User role: $role");

            // Adjusted comparison based on the role storage type (integer)
            if ($role == 'guide') { // Changed strict comparison to loose one
                // The user is a guide, proceed with the request
                return $next($request);
            }
        }

        // The user is not a guide or not authenticated, return an unauthorized response
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
