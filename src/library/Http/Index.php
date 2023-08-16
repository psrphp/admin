<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http;

use App\Psrphp\Admin\Lib\Json;
use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
use Composer\Autoload\ClassLoader;
use PsrPHP\Framework\App;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;
use ReflectionClass;

/**
 * 后台主页
 */
class Index extends Common
{
    public function get(
        App $app,
        Auth $auth,
        Account $account,
        Request $request,
        Template $template,
    ) {
        switch ($request->get('t')) {
            case 'home':
                $diys = $account->getData($auth->getId(), 'admin_diy', []);
                foreach ($diys as &$vo) {
                    list($name, $pkg) = explode('@', $vo['widget'] . '@');
                    if ($pkg) {
                        $cfg = Json::readFromFile($app->get($pkg)['dir'] . '/src/widget/config.json', []);
                    } else {
                        $dir = dirname(dirname(dirname((new ReflectionClass(ClassLoader::class))->getFileName())));
                        $cfg = Json::readFromFile($dir  . '/widget/config.json', []);
                    }
                    $vo = array_merge($cfg[$name] ?? [], $vo);
                }
                return $template->renderFromFile('home@psrphp/admin', [
                    'auth' => $auth,
                    'account' => $account,
                    'diys' => $diys,
                ]);
                break;

            default:
                return $template->renderFromFile('index@psrphp/admin', [
                    'auth' => $auth,
                    'account' => $account,
                    'stick_menus' => $account->getData($auth->getId(), 'psrphp_admin_menu', []),
                ]);
                break;
        }
    }
}
