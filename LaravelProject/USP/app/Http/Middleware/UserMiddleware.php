<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class UserMiddleware
{
    function handle($request, Closure $next)
    {
        if (!Auth::check())
            response()->view('auth.login');

        return $next($request);
    }
}
