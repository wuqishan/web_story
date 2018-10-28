<?php

namespace App\Helper;

class NavHelper
{
    /**
     * 返回需要高亮的那个route name
     *
     * @return int|mixed|string
     */
    public static function highlight()
    {
        $current = '';
        $route_name = request()->route()->getName();
        $nav_config = config('nav_highlight');
        foreach ($nav_config as $k => $c) {
            if (in_array($route_name, $c)) {
                $current = $k;
                break;
            }
        }

        return $current;
    }


}

