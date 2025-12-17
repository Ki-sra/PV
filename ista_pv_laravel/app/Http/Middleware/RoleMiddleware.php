<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: add middleware and pass roles as param: 'role:admin,manager'
     */
    public function handle(Request $request, Closure $next, $roles = null)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if (!$roles) {
            return $next($request);
        }

        $allowed = explode(',', $roles);
        if (!in_array($request->user()->role, $allowed)) {
            abort(403);
        }

        return $next($request);
    }
}
