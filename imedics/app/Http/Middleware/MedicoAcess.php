<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class MedicoAcess
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->level == 'M' || Auth::user()->level == 'A') {
            return $next($request);
        }
        
        return redirect('/home');
    }
}
