<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Menu;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Account;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;

/**
 * 收藏菜单
 */
class Stick extends Common
{
    public function get(
        Request $request,
        Db $db,
        Account $account
    ) {
        $menus = json_decode($db->get('psrphp_admin_account_info', 'value', [
            'account_id' => $account->getAccountId(),
            'key' => 'psrphp_admin_menu',
        ]) ?: '[]', true);

        $menu = [
            'url' => $request->get('url'),
            'title' => $request->get('title'),
        ];
        $key = array_search($menu, $menus);

        if ($key !== false) {
            unset($menus[$key]);
        } else {
            $menus[] = $menu;
        }
        if ($db->get('psrphp_account_info', '*', [
            'account_id' => $account->getAccountId(),
            'key' => 'psrphp_admin_menu',
        ])) {
            $db->update('psrphp_account_info', [
                'value' => json_encode($menus),
            ], [
                'account_id' => $account->getAccountId(),
                'key' => 'psrphp_admin_menu',
            ]);
        }
        return Response::success('成功~');
    }
}
