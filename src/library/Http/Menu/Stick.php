<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Menu;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Model\Account;
use PsrPHP\Framework\Config;
use PsrPHP\Request\Request;

/**
 * 收藏菜单
 */
class Stick extends Common
{
    public function get(
        Request $request,
        Config $config,
        Account $account
    ) {
        $menus = $config->get('menus.account_' . $account->getAccountId(), []);
        $menu = [
            'url' => $request->get('url'),
            'title' => $request->get('title'),
        ];
        $key = array_search($menu, $menus);

        if ($key !== false) {
            unset($menus[$key]);
            $config->save('menus.account_' . $account->getAccountId(), $menus);
            return $this->success('已取消收藏');
        } else {
            $menus[] = $menu;
            $config->save('menus.account_' . $account->getAccountId(), $menus);
            return $this->success('已收藏');
        }
    }
}
