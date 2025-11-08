<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddSecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Add CSP header to allow loading images from our own domain
        $response->header('Content-Security-Policy', "img-src 'self' data: blob: http://localhost:* https://localhost:*;");

        return $response;
    }
}