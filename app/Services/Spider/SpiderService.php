<?php

namespace App\Services\Spider;

use App\Services\Service;
use QL\QueryList;
use QL\Ext\CurlMulti;

class SpiderService extends Service
{
    public $ql = null;
    public $host = '';

    public function __construct()
    {
        parent::__construct();

        $this->ql = QueryList::getInstance();
        $this->ql->use(CurlMulti::class);
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
        $this->host($url);

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

    public function host($url)
    {
        $parse = parse_url($url);
        if (isset($parse['host'])) {
            if (isset($parse['scheme'])) {
                $this->host = trim($parse['scheme']) . '://' . trim($parse['host']);
            } else {
                $this->host = 'http://' . trim($parse['host']);
            }
        }

        return $this->host;
    }

    public function urlJoin($url)
    {
        $parse = parse_url($url);
        if (isset($parse['path'])) {
            $results = $this->host . $parse['path'];
        } else {
            $results = $this->host;
        }

        return $results;
    }
}