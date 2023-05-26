<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Diy;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Json;
use App\Psrphp\Admin\Lib\Response;
use Composer\InstalledVersions;
use PsrPHP\Framework\Config;
use PsrPHP\Framework\Framework;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;
use ReflectionClass;

/**
 * 主页DIY
 */
class Index extends Common
{
    public function get(
        Template $template,
        Json $json
    ) {
        $widgets = [];

        $widgets['自定义'] = [];
        $dir = dirname(dirname(dirname((new ReflectionClass(InstalledVersions::class))->getFileName()))) . '/widget/';
        $cfg = $json->read($dir . 'config.json', []);
        foreach (glob($dir . '*.php') as $file) {
            $name = substr($file, strlen($dir), -4);
            $widgets['自定义'][$name] = [
                'name' => $name,
                'title' => $cfg[$name]['title'] ?? '',
                'fullname' => $name,
            ];
        }

        foreach (Framework::getAppList() as $app) {
            $widgets[$app['name']] = [];
            $dir = $app['dir'] . '/src/widget/';
            $cfg = $json->read($dir . 'config.json', []);
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
        Config $config,
        Request $request
    ) {
        switch ($request->post('t')) {
            case 'add':
                $diy = $config->get('diy@psrphp/admin', []);
                $diy[] = [
                    'widget' => $request->post('widget'),
                    'size' => $request->post('size'),
                ];
                $config->save('diy@psrphp/admin', $diy);
                return Response::success('操作成功！');
                break;

            case 'left':
                $diy = $config->get('diy@psrphp/admin', []);
                $index = $request->post('index');
                $tmp = $diy[$index - 1];
                $diy[$index - 1] = $diy[$index];
                $diy[$index] = $tmp;
                $config->save('diy@psrphp/admin', $diy);
                return Response::success('操作成功！');
                break;

            case 'right':
                $diy = $config->get('diy@psrphp/admin', []);
                $index = $request->post('index');
                $tmp = $diy[$index + 1];
                $diy[$index + 1] = $diy[$index];
                $diy[$index] = $tmp;
                $config->save('diy@psrphp/admin', $diy);
                return Response::success('操作成功！');
                break;

            case 'remove':
                $diy = $config->get('diy@psrphp/admin', []);
                $index = $request->post('index');
                unset($diy[$index]);
                $config->save('diy@psrphp/admin', array_values($diy));
                return Response::success('操作成功！');
                break;

            default:
                return Response::error('参数错误');
                break;
        }
    }
}
