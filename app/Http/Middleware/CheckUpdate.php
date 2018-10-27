<?php

namespace App\Http\Middleware;

use Closure;

class CheckUpdate
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
        if (empty(session('user'))) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
