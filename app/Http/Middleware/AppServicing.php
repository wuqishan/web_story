<?php

namespace App\Http\Middleware;

use Closure;

class AppServicing
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
        $status = (bool) config('app.servicing');
        if (! $status) {
            exit('网站修整中，暂停服务！');
        }

        return $next($request);
    }
}
