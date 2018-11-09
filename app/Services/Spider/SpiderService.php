<?php

namespace App\Services\Spider;

use App\Services\Service;
use QL\QueryList;

class SpiderService extends Service
{
    public $ql = null;
    public $host = '';

    public function __construct()
    {
        parent::__construct();
        $this->ql = QueryList::getInstance();
    }

    public function getHeader()
    {
        return [
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'Accept-Language' => 'zh-CN,zh;q=0.9',
            'Accept-Encoding' => 'gzip, deflate',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3371.0 Safari/537.36'
        ];
    }

    public function spider($url, $method = 'get', $params = [], $otherParams = [])
    {
        if (empty($otherParams)) {
            $otherParams = [
                'headers' => $this->getHeader()
            ];
        }

        if (strtolower($method) === 'get') {
            $this->ql->get($url, $params, $otherParams);
        } else {
            $this->ql->post($url, $params, $otherParams);
        }

        return $this->ql;
    }
}