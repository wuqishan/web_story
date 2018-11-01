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
}