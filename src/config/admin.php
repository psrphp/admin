<?php

use App\Psrphp\Admin\Http\Account\Index;
use App\Psrphp\Admin\Http\Cache\Clear;
use App\Psrphp\Admin\Http\Diy\Index as DiyIndex;
use App\Psrphp\Admin\Http\Log\Index as LogIndex;
use App\Psrphp\Admin\Http\Role\Index as RoleIndex;
use App\Psrphp\Admin\Model\Account;
use PsrPHP\Framework\Framework;
use PsrPHP\Router\Router;

return [
    'menus' => Framework::execute(function (
        Account $account,
        Router $router
    ): array {
        $menus = [];
        if ($account->checkAuth(DiyIndex::class)) {
            $menus[] = [
                'url' => $router->build('/psrphp/admin/diy/index'),
                'title' => '主页DIY',
            ];
        }
        if ($account->checkAuth(Index::class)) {
            $menus[] = [
                'url' => $router->build('/psrphp/admin/account/index'),
                'title' => '账户管理',
            ];
        }
        if ($account->checkAuth(RoleIndex::class)) {
            $menus[] = [
                'url' => $router->build('/psrphp/admin/role/index'),
                'title' => '角色管理',
            ];
        }
        if ($account->checkAuth(LogIndex::class)) {
            $menus[] = [
                'url' => $router->build('/psrphp/admin/role/index'),
                'title' => '日志管理',
            ];
        }
        if ($account->checkAuth(Clear::class)) {
            $menus[] = [
                'url' => $router->build('/psrphp/admin/cache/clear'),
                'title' => '清理缓存',
            ];
        }
        return $menus;
    }),
];
