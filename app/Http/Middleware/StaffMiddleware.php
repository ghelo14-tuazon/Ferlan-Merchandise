<?php

namespace App\Http\Middleware;

use Closure;

class StaffMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the user has the staff role or any other criteria
        if (auth()->check() && auth()->user()->role == 'staff') {
            return $next($request);
        }

        abort(403, 'Unauthorized action.'); // or redirect to login or another page
    }
}
