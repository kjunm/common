<?php
namespace common\utils;
/**
 * 阿里云apigateway格式化返回
 * @Author wangjm wangjm06@mingyuanyun.com
 * @DateTime 2023-01-11
 */
class ResponseUtils
{
    public static function success($data = [], $message = "")
    {
        return json_encode(
            [
                "isBase64Encoded" => "false",
                "statusCode" => "200",
                "headers" => [
                    "Access-Control-Allow-Origin" => "*",
                    "Access-Control-Allow-Credentials" => true,
                    "Access-Control-Allow-Headers" =>
                    "X-Requested-With,content-type,auth-token,X-Log-Id",
                    "Access-Control-Allow-Methods" =>
                    "GET,POST,PUT,DELETE,HEAD,OPTIONS,PATCH",
                    "Access-Control-Max-Age" => 600
                ],
                "body" => [
                    "success" => true,
                    "error_code" => 200,
                    "message" => $message,
                    "data" => $data
                ]
            ]
        );
    }

    public static function fail($message = "", $error_code = 0, $data = [])
    {
        return json_encode(
            [
                "isBase64Encoded" => "false",
                "statusCode" => "200",
                "headers" => [
                    "Access-Control-Allow-Origin" => "*",
                    "Access-Control-Allow-Credentials" => true,
                    "Access-Control-Allow-Headers" =>
                    "X-Requested-With,content-type,auth-token,X-Log-Id",
                    "Access-Control-Allow-Methods" =>
                    "GET,POST,PUT,DELETE,HEAD,OPTIONS,PATCH",
                    "Access-Control-Max-Age" => 600
                ],
                "body" => [
                    "success" => false,
                    "error_code" => $error_code,
                    "message" => $message,
                    "data" => $data
                ]
            ]
        );
    }
}
