<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateMiddleware
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
        if (\Auth::user() !== null) {
            return $next($request);
        }
        //abort(404, "NOT FOUND!");
        return redirect('/login');
    }
}
