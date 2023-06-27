<?php

use App\Psrphp\Admin\Http\Account\Index as AccountIndex;
use App\Psrphp\Admin\Http\Cache\Clear;
use App\Psrphp\Admin\Http\Department\Index as DepartmentIndex;
use App\Psrphp\Admin\Http\Diy\Index as DiyIndex;
use App\Psrphp\Admin\Http\Log\Index as LogIndex;
use App\Psrphp\Admin\Http\Plugin\Index as PluginIndex;
use App\Psrphp\Admin\Http\Theme\Index as ThemeIndex;
use App\Psrphp\Admin\Http\Widget\Index as WidgetIndex;

return [
    'menus' => [[

        'node' => DepartmentIndex::class,
        'title' => '组织结构',
    ], [
        'node' => AccountIndex::class,
        'title' => '账户管理',
    ], [
        'node' => PluginIndex::class,
        'title' => '插件管理',
    ], [
        'node' => ThemeIndex::class,
        'title' => '主题管理',
    ], [
        'node' => WidgetIndex::class,
        'title' => '挂件管理',
    ], [
        'node' => LogIndex::class,
        'title' => '日志管理',
    ], [
        'node' => DiyIndex::class,
        'title' => '主页DIY',
    ], [
        'node' => Clear::class,
        'title' => '清理缓存',
    ]],
];
