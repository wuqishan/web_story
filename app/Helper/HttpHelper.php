<?php

namespace App\Helper;

class HttpHelper
{
    /**
     * 模拟http请求
     *
     * @param $url
     * @param string $method
     * @param null $data
     * @param array $header
     * @return mixed
     */
    public static function send($url, $method = 'GET', $data = null, $header = [])
    {
        $connection = curl_init();

        curl_setopt($connection, CURLOPT_URL, $url);
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($connection, CURLOPT_TIMEOUT, 60);
        curl_setopt($connection, CURLOPT_HTTPHEADER, $header);

        if ('POST' == strtoupper($method)) {
            curl_setopt($connection, CURLOPT_POST, 1);

            if ($data) {
                curl_setopt($connection, CURLOPT_POSTFIELDS, $data);
            }
        }
        $response = curl_exec($connection);
        curl_close($connection);

        return $response;
    }
}
