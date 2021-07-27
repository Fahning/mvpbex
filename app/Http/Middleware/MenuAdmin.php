<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MenuAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->cnpj == "00000000000000"){
            return $next($request);
        }else{
            return redirect()->route('dashboard');
        }
    }
}
