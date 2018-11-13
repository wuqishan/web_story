<?php

namespace App\Helper;

use Illuminate\Support\Facades\Cache;

class CookieHelper
{
    /**
     * 键值对的存储
     *
     * @param string    $key
     * @param mixed     $value
     * @param int       $minutes
     * @return mixed
     */
    public static function set($key, $value, $minutes = 120)
    {
        if (! static::getCacheStatus()) {
            return null;
        }

        return Cache::put(static::formatterKey($key), $value, $minutes);
    }

    /**
     * @param $key
     * @return bool|null
     */
    public static function has($key)
    {
        if (! static::getCacheStatus()) {
            return null;
        }

        return Cache::has($key);
    }

    /**
     * 根据键获取cache值
     *
     * @param string    $key
     * @return mixed
     */
    public static function get($key)
    {
        if (! static::getCacheStatus()) {
            return null;
        }

        return Cache::get(static::formatterKey($key));
    }

    /**
     * 删除键对应的值
     *
     * @param string    $key
     * @return mixed
     */
    public static function delete($key)
    {
        if (! static::getCacheStatus()) {
            return null;
        }

        return Cache::forget(static::formatterKey($key));
    }

    /**
     * 清空缓存
     *
     * @return null
     */
    public static function flush()
    {
        if (! static::getCacheStatus()) {
            return null;
        }

        return Cache::clear();
    }
}
