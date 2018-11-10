<?php

namespace App\Helper;

use QL\QueryList;
use QL\Ext\CurlMulti;
use Ares333\Curl\Toolkit;

class CurlMultiHelper
{
    public static function get($urls, $closures, $opt = [])
    {
        $results = [];
        if (empty($opt)) {
            $opt = [
                'maxThread' => 16,
                // Trigger curl error or user error before max try times reached.If reached $error will be called.
                'maxTry' => 30,
                // Global CURLOPT_* for all tasks.
                'opt' => [
                    CURLOPT_TIMEOUT => 16,
                    CURLOPT_CONNECTTIMEOUT => 1,
                    CURLOPT_RETURNTRANSFER => true
                ],
                // Cache is identified by url.If cache finded,the class will not access the network,but return the cache directly.
                // 'cache' => ['enable' => false, 'compress' => false, 'dir' => null, 'expire' =>86400, 'verifyPost' => false]
            ];
        }
        $ql = QueryList::getInstance();
        $ql->use(CurlMulti::class);
        $ql->curlMulti($urls)->success(function (QueryList $ql,CurlMulti $curl,$r) use ($closures, & $results) {
            $results[$r['info']['url']] = $closures($ql, $curl, $r);
            $ql->destruct();
        })->start($opt);

        return array_merge(array_flip($urls), $results);
    }
}
