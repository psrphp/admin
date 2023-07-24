<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Model;

use PsrPHP\Database\Db;
use PsrPHP\Framework\Framework;
use PsrPHP\Framework\Route;

class Log
{
    public static function record(string $tips = '')
    {
        Framework::execute(function (
            Db $db,
            Auth $auth,
            Route $route
        ) use ($tips) {
            $db->insert('psrphp_admin_log', [
                'account_id' => $auth->isLogin() ? $auth->getId() : 0,
                'node' => $route->getHandler(),
                'method' => $_SERVER['REQUEST_METHOD'],
                'data' => json_encode(array_diff_key($GLOBALS, ['GLOBALS' => '']), JSON_UNESCAPED_UNICODE),
                'ip' => $_SERVER['REMOTE_ADDR'],
                'time' => time(),
                'tips' => $tips,
            ]);
        });
    }
}
