<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->status !== 'aktif') {
            return redirect()->route('pending-verification');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            return redirect()->route(auth()->user()->getDashboardRoute());
        }

        return $next($request);
    }
}
