<?php
namespace common\utils;

use Exception;

class HttpUtils
{
    public static function get($url)
    {
        $ch = curl_init();
        self::__setSSLOpts($ch, $url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        self::__setSSLOpts($ch, $url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        return self::__exec($ch);
    }

    public static function post($url, $data)
    {
        $ch = curl_init();
        self::__setSSLOpts($ch, $url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        return self::__exec($ch);
    }

    private static function __setSSLOpts($ch, $url)
    {
        if (stripos($url, "https://") !== false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        }
    }

    private static  function __exec($ch)
    {
        $output = curl_exec($ch);
        $status = curl_getinfo($ch);
        curl_close($ch);
        if ($output === false) {
            throw new Exception("network error");
        }
        if (intval($status["http_code"]) != 200) {
            throw new Exception(
                "unexpected http code " . intval($status["http_code"])
            );
        }
        return $output;
    }
}
