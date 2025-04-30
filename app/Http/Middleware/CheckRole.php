<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        // dd(auth()->user()->role);
        // dd($roles);

        // Check if user has any of the required roles
        if (!in_array(auth()->user()->role, $roles)) {
            // abort(403, 'Unauthorized action.');
            return redirect()->route('home');
        }

        return $next($request);
    }
}
