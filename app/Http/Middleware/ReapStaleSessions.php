<?php

namespace App\Http\Middleware;

use App\Services\SessionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReapStaleSessions
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            app(SessionService::class)->reapStaleSessions();
        } catch (\Throwable $exception) {
            // A cleanup failure must never break a device request.
            report($exception);
        }

        return $next($request);
    }
}
