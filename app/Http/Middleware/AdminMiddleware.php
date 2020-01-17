<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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

            if (\Auth::user()->rol->type == 'Admin') {
                return $next($request);
            }

            return redirect('/');
        }

        abort(403, "Forbidden - You don't have permission to access / on this server");
        //return redirect('/');
         
    }
}
