<?php

namespace App\Http\Middleware;

use Closure;

class middlewareArrendatario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->rol != 'Arrendatario') {
            return redirect('/');
        }
        return $next($request);
    }
}
