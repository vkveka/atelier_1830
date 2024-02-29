<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AbortCart
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
        abort(404, 'PAGE NON TROUVEE');
        return $next($request);
    }
}
