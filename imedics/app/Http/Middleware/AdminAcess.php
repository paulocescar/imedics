<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class AdminAcess
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->level == 'A') {
            return $next($request);
        }
        
        return redirect('/home');
    }
}
