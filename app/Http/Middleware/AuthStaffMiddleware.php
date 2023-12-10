<?php
// app/Http/Middleware/AuthStaffMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthStaffMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        return redirect()->route('staff.login')->with('error', 'You must be logged in as staff.');
    }
}
