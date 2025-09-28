<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CspMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $cspValue = collect([
            "script-src 'self' 'unsafe-eval' 'unsafe-inline' https://unpkg.com",
            "style-src 'self' 'unsafe-inline' https://unpkg.com https://fonts.bunny.net",
            "img-src 'self' data: https://*.tile.openstreetmap.org https://raw.githubusercontent.com https://*.basemaps.cartocdn.com https://ui-avatars.com",
            "font-src 'self' https://fonts.bunny.net",
        ])->implode('; ');

        $response->headers->set('Content-Security-Policy', $cspValue);

        return $response;
    }
}
