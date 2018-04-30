<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckAdmin
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
        if (!Auth::check())
        {
            session()->flash('danger', 'You must be logged in to access this page.');
            return redirect()->route('login');
        }

        //Also update the ContactMiddleware middleware. 
        if (!(Auth::user()->isAdmin()))
        {
            session()->flash('danger', 'You must be logged in as an admin to access this page.');
            return redirect()->route('home');
        }

        return $next($request);
    }
}
