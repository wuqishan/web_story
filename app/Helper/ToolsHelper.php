<?php

namespace App\Helper;


class ToolsHelper
{

    /**
     * 计算除去所有字符后章节的字数长度
     *
     * @param $content
     * @return int
     */
    public static function calcWords($content)
    {
        $content = strip_tags($content);
        $content = preg_replace('/[,\.\?\'"。，？\!！\s”“]/u', '', $content);

        return mb_strlen($content);
    }

    /**
     * 字符串截取
     *
     * @param $str
     * @param $start
     * @param null $length
     * @return bool|string
     */
    public static function subStr($str, $start, $length = null)
    {
        return mb_substr($str, $start, $length);
    }

    /**
     * 获取图片的后缀名
     *
     * @param $image_url
     * @return bool|null|string|string[]
     */
    public static function getImageExt($image_url)
    {
        $ext = substr($image_url, strrpos($image_url, '.') + 1);
        $ext = preg_replace('/^(\w+)\??.*/', '$1', $ext);

        return $ext;
    }

    /**
     * 判断是不是手机web
     *
     * @return bool
     */
    public static function isMobile()
    {
        $results = false;
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            $results = true;
        }else if (isset ($_SERVER['HTTP_VIA'])) {
            $results = stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        } else if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array(
                'mobile',
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                $results = true;
            }
        } else if (isset ($_SERVER['HTTP_ACCEPT'])) { // 协议法，因为有可能不准确，放到最后判断
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                $results = true;
            }
        }

        return $results;
    }
}