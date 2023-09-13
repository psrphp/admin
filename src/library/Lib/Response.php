<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Lib;

use Psr\Http\Message\ResponseInterface;
use PsrPHP\Psr17\Factory;
use PsrPHP\Template\Template;

class Response
{
    public static function create(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return (new Factory)->createResponse($code, $reasonPhrase);
    }

    public static function success(string $message, $data = null, $redirect_url = null): ResponseInterface
    {
        $res = [
            'errcode' => 0,
            'message' => $message,
        ];
        if (!is_null($redirect_url)) {
            $res['redirect_url'] = $redirect_url;
        }
        $response = self::create();
        if (self::isAcceptJson()) {
            if (!is_null($data)) {
                $res['data'] = $data;
            }
            $response->getBody()->write(json_encode($res, JSON_UNESCAPED_UNICODE));
            $response = $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write((new Template)->renderFromString(self::getTpl(), $res));
        }
        return $response;
    }

    public static function error(string $message, $redirect_url = null, $errcode = 1, $data = null): ResponseInterface
    {
        $res = [
            'errcode' => $errcode,
            'message' => $message,
        ];
        if (!is_null($redirect_url)) {
            $res['redirect_url'] = $redirect_url;
        }
        $response = self::create();
        if (self::isAcceptJson()) {
            if (!is_null($data)) {
                $res['data'] = $data;
            }
            $response->getBody()->write(json_encode($res, JSON_UNESCAPED_UNICODE));
            $response = $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write((new Template)->renderFromString(self::getTpl(), $res));
        }
        return $response;
    }

    public static function redirect(string $url, int $http_status_code = 302): ResponseInterface
    {
        $response = self::create($http_status_code);
        return $response->withHeader('Location', $url);
    }

    public static function html(string $string): ResponseInterface
    {
        $response = self::create();
        $response->getBody()->write($string);
        return $response;
    }

    public static function json($data): ResponseInterface
    {
        $response = self::create();
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }

    private static function isAcceptJson(): bool
    {
        if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
            return true;
        }
        return false;
    }

    private static function getTpl(): string
    {
        return <<<'str'
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <title>{$message}</title>
    <style>
        html, body{
            width:100%;
            height:100%;
            padding:0;
            margin:0;
        }
    </style>
</head>

<body>
    <div style="padding:0 20px;">
        <div style="font-size:150px;letter-spacing: 25px;">{if $errcode}:({else}:){/if}</div>
        <div style="margin: 20px auto;font-size: 38px;letter-spacing: 2px;">{$message}</div>
        {if $errcode}
        <div style="margin: 5px auto;letter-spacing: 2px;color:gray;">错误代码:{$errcode}</div>
        {/if}
        {if isset($redirect_url)}
        <a style="margin: 20px auto;font-size:18px;text-decoration: none;letter-spacing: 1px;color: #4b72ff;" href="{echo $redirect_url}" id="jump">跳转中</a> <span id="time">3</span><span>s</span>
        {else}
        <a style="margin: 20px auto;font-size:18px;text-decoration: none;letter-spacing: 1px;color: #4b72ff;" href="javascript:history.back();" id="jump">返回</a> <span id="time">3</span><span>s</span>
        {/if}
    </div>
    <script>
        var time = 3;
        var timer = setInterval(function(){
            time -= 1;
            if(time > 0){
                document.getElementById("time").innerHTML=time;
            } else {
                clearInterval(timer);
                document.getElementById("jump").click();
            }
        }, 1000);
    </script>
</body>

</html>
str;
    }
}
