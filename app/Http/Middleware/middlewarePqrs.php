<?php

namespace App\Http\Middleware;

use Closure;

class middlewarePqrs
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
        $url = explode('/',request()->url());
        $pqrs = \App\Pqrs::find((int)$url[count($url)-1]);
        if ($pqrs->remitente == auth()->user()->id || $pqrs->destinatario == auth()->user()->id) {
             return $next($request);  
        }else{
            return back()->with('flash','Esta intentando ingresar a conversaciones no permitidas');
        }
    }
}
