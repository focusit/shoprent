<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Unauthorized. Please login as an admin.');
    }
}
