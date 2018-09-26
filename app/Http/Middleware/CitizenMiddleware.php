<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CitizenMiddleware
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
        if(Auth::guest()||Auth::user()->role!='citizen'){
            Session::flash('success','You must be logged in as a citizen to perform desired function.');
            return redirect('/login');
        }
        return $next($request);
    }
}
