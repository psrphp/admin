<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Menu;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
use PsrPHP\Request\Request;
use PsrPHP\Router\Router;

/**
 * 收藏菜单
 */
class Stick extends Common
{
    public function get(
        Request $request,
        Router $router,
        Auth $auth,
        Account $account
    ) {
        $menus = $account->getData($auth->getId(), 'psrphp_admin_menu', []);
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
        $account->setData($auth->getId(), 'psrphp_admin_menu', $menus);
        return Response::redirect($router->build('/psrphp/admin/menu/index'));
    }
}
