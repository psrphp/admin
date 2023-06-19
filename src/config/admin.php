<?php

use App\Psrphp\Admin\Http\Account\Index;
use App\Psrphp\Admin\Http\Cache\Clear;
use App\Psrphp\Admin\Http\Diy\Index as DiyIndex;
use App\Psrphp\Admin\Http\Log\Index as LogIndex;
use App\Psrphp\Admin\Http\Role\Index as RoleIndex;

return [
    'menus' => [[
        'node' => DiyIndex::class,
        'title' => '主页DIY',
    ], [
        'node' => Index::class,
        'title' => '账户管理',
    ], [
        'node' => RoleIndex::class,
        'title' => '角色管理',
    ], [
        'node' => LogIndex::class,
        'title' => '日志管理',
    ], [
        'node' => Clear::class,
        'title' => '清理缓存',
    ]],
];
