<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Menu;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
use App\Psrphp\Admin\Model\MenuProvider;
use PsrPHP\Router\Router;
use PsrPHP\Template\Template;

/**
 * 功能地图
 */
class Index extends Common
{
    public function get(
        Auth $auth,
        Router $router,
        Account $account,
        Template $template,
        MenuProvider $menuProvider
    ) {

        $menus = [];
        foreach ($menuProvider->all() as $vo) {
            $vo['url'] = $router->build($this->buildPathFromNode($vo['node'] ?? ''), $vo['query'] ?? []);
            $vo['auth'] = $account->checkAuth($auth->getId(), $vo['node'] ?? '');
            $menus[$this->getAppName($vo['node'])][] = $vo;
        }

        return $template->renderFromFile('menu/index@psrphp/admin', [
            'sticks' => $account->getData($auth->getId(), 'psrphp_admin_menu', []),
            'menus' => $menus,
        ]);
    }

    private function buildPathFromNode(string $node): string
    {
        $paths = [];
        foreach (explode('\\', $node) as $vo) {
            $paths[] = strtolower(preg_replace('/([A-Z])/', "-$1", lcfirst($vo)));
        }
        unset($paths[0]);
        unset($paths[3]);
        return '/' . implode('/', $paths);
    }

    private function getAppName(string $node): string
    {
        $paths = [];
        foreach (explode('\\', $node) as $vo) {
            $paths[] = strtolower(preg_replace('/([A-Z])/', "-$1", lcfirst($vo)));
        }
        return $paths[1] . '/' . $paths[2];
    }
}
