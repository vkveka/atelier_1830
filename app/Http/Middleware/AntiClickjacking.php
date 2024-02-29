<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AntiClickjacking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Ajoutez l'en-tête anti-clickjacking ici
        $response->header('X-Frame-Options', 'DENY');

        return $response;
    }
}
