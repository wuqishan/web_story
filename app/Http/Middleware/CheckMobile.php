<?php

namespace App\Http\Middleware;

use App\Helper\ToolsHelper;
use Closure;
use Illuminate\Support\Facades\Route;

class CheckMobile
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

        if (ToolsHelper::isMobile()) {
//            $route_name = Route::currentRouteName();
//            return redirect()->route('mobile-index');
        }

        return $next($request);
    }
}
