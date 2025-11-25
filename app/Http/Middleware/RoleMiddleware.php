<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        $allRoles = $user->roles->pluck('name')->toArray();
        //dd($allRoles, $roles);
        // If user role is not in allowed roles, block access
        if (!array_intersect($roles, $allRoles)) {
            abort(403, 'Unauthorized action.');
        }


        return $next($request);
    }
}
