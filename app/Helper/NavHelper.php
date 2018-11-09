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
        $route_name = request()->route()->getName();
        $nav_config = config('nav_highlight');

        if (isset($nav_config[$route_name])) {
            $current = $nav_config[$route_name];
        } else {
            $current = $route_name;
        }

        return $current;
    }


}

