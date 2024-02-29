<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is not authenticated or not a regular user
        if (!auth()->check() || auth()->user()) {
            // Redirect to the login page
            return redirect()->route('login.form')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
