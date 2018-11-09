<?php

namespace App\Services\Spider;

use App\Helper\ToolsHelper;

class SubSpiderService extends SpiderService
{
    /**
     * 返回文章的内容和字数
     *
     * @param $url
     * @return array
     */
    public function getContent($url)
    {
        $ql = $this->spider($url);

        $content = $ql->find('#content')->html();
        $content = '<div id="content">' . $content . '</div>';
        $number_of_words = ToolsHelper::calcWords($content);

        return [$content, $number_of_words];
    }
}