<?php

namespace App\Http\Middleware;

use App\Services\SettingService;
use Closure;

class AssignCommonImage
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
        $common = ['banner', 'logo', 'seo.title', 'seo.keywords', 'seo.description'];
        $settingService = new SettingService();
        $common_info = $settingService->getByNameFromCache($common);
        if (! empty($common_info)) {
            $info = [];
            foreach ($common_info as $v) {
                if ($v['name'] === 'banner') {
                    $info['banner'][] = $v['value'];
                } else {
                    $info[$v['name']] = $v['value'];
                }
            }
//            dd($info);
            view()->share('_common_',$info);
        }

        return $next($request);
    }
}
