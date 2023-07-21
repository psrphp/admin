<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Diy;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Json;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
use Composer\InstalledVersions;
use PsrPHP\Framework\App;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;
use ReflectionClass;

/**
 * 主页DIY
 */
class Index extends Common
{
    public function get(
        App $app,
        Template $template
    ) {
        $widgets = [];

        $widgets['自定义'] = [];
        $dir = dirname(dirname(dirname((new ReflectionClass(InstalledVersions::class))->getFileName()))) . '/widget/';
        $cfg = Json::readFromFile($dir . 'config.json', []);
        foreach (glob($dir . '*.php') as $file) {
            $name = substr($file, strlen($dir), -4);
            $widgets['自定义'][$name] = [
                'name' => $name,
                'title' => $cfg[$name]['title'] ?? '',
                'fullname' => $name,
            ];
        }

        foreach ($app->all() as $app) {
            $widgets[$app['name']] = [];
            $dir = $app['dir'] . '/src/widget/';
            $cfg = Json::readFromFile($dir . 'config.json', []);
            foreach (glob($dir . '*.php') as $file) {
                $name = substr($file, strlen($dir), -4);
                $widgets[$app['name']][$name] = [
                    'name' => $name,
                    'title' => $cfg[$name]['title'] ?? '',
                    'fullname' => $name . '@' . $app['name'],
                ];
            }
        }

        return $template->renderFromFile('diy/index@psrphp/admin', [
            'widgets' => $widgets,
        ]);
    }

    public function post(
        Request $request,
        Account $account,
        Auth $auth
    ) {
        switch ($request->post('t')) {
            case 'add':
                $diy = $account->getData($auth->getId(), 'admin_diy', []);
                $diy[] = [
                    'widget' => $request->post('widget'),
                    'size' => $request->post('size'),
                ];
                $account->setData($auth->getId(), 'admin_diy', $diy);
                return Response::success('操作成功！');
                break;

            case 'left':
                $diy = $account->getData($auth->getId(), 'admin_diy', []);
                $index = $request->post('index');
                $tmp = $diy[$index - 1];
                $diy[$index - 1] = $diy[$index];
                $diy[$index] = $tmp;
                $account->setData($auth->getId(), 'admin_diy', $diy);
                return Response::success('操作成功！');
                break;

            case 'right':
                $diy = $account->getData($auth->getId(), 'admin_diy', []);
                $index = $request->post('index');
                $tmp = $diy[$index + 1];
                $diy[$index + 1] = $diy[$index];
                $diy[$index] = $tmp;
                $account->setData($auth->getId(), 'admin_diy', $diy);
                return Response::success('操作成功！');
                break;

            case 'remove':
                $diy = $account->getData($auth->getId(), 'admin_diy', []);
                $index = $request->post('index');
                unset($diy[$index]);
                $account->setData($auth->getId(), 'admin_diy', $diy);
                return Response::success('操作成功！');
                break;

            default:
                return Response::error('参数错误');
                break;
        }
    }
}
