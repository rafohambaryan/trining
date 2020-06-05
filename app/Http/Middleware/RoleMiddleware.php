<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param mixed ...$role
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        if (Auth::check() && in_array(Auth::user()->role, $role))
            return $next($request);
        return response(view('errors.404'));
    }
}
