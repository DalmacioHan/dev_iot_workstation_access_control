<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow the request to proceed if logged in AND is a superadmin
        if (Auth::check() && Auth::user()->isSuperAdmin()) {
            return $next($request);
        }

        abort(403, 'Unauthorized action. Super Admin access required.');
    }
}
