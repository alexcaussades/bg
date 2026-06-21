<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class TokenStock
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    
    public function handle(Request $request, Closure $next): Response
    {
        if (!Cookie::has('token_stock')) {
            return redirect()->route('stock.index')->with('error', 'Token manquant. Veuillez générer un token avant de continuer.');
        }

        return $next($request);
    }

    
}
