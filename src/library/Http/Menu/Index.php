<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Menu;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
use Composer\InstalledVersions;
use PsrPHP\Framework\Config;
use PsrPHP\Framework\Framework;
use PsrPHP\Router\Router;
use PsrPHP\Template\Template;

/**
 * 功能地图
 */
class Index extends Common
{
    public function get(
        Template $template,
        Auth $auth,
        Account $account,
        Config $config,
        Router $router
    ) {

        $menus = [];
        foreach (Framework::getAppList() as $app) {
            foreach ($config->get('admin.menus@' . $app['name'], []) as $value) {
                $value['url'] = $router->build($this->buildPathFromNode($value['node'] ?? ''), $value['query'] ?? []);
                $value['auth'] = $account->checkAuth($auth->getId(), $value['node'] ?? '');
                $value['plugin'] = !InstalledVersions::isInstalled($app['name']);
                $value['core'] = $value['plugin'] ? false : (substr($app['name'], 0, 7) == 'psrphp/');
                $menus[] = $value;
            }
        }

        return $template->renderFromFile('menu/index@psrphp/admin', [
            'stick_menus' => $account->getData($auth->getId(), 'psrphp_admin_menu', []),
            'menus' => $menus,
        ]);
    }

    private function buildPathFromNode(string $node): string
    {
        $paths = [];
        foreach (explode('\\', $node) as $vo) {
            $paths[] = preg_replace('/([A-Z])/', "-$1", lcfirst($vo));
        }
        unset($paths[0]);
        unset($paths[3]);
        return '/' . implode('/', $paths);
    }
}
