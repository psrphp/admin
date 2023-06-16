<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Model;

use PsrPHP\Database\Db;
use PsrPHP\Framework\Route;

class Log
{

    private $db;
    private $route;
    private $account;

    public function __construct(
        Db $db,
        Route $route,
        Account $account
    ) {
        $this->db = $db;
        $this->route = $route;
        $this->account = $account;
    }

    public function record(string $tips = '')
    {
        $data = $GLOBALS;
        unset($data['GLOBALS']);
        $this->db->insert('psrphp_admin_log', [
            'account_id' => $this->account->isLogin() ? $this->account->getAccountId() : 0,
            'node' => $this->route->getHandler(),
            'method' => $_SERVER['REQUEST_METHOD'],
            'data' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'time' => time(),
            'tips' => $tips,
        ]);
    }
}
