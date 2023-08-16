<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Widget;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Json;
use Composer\InstalledVersions;
use PsrPHP\Framework\App;
use PsrPHP\Template\Template;
use ReflectionClass;

/**
 * 查看所有挂件
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
            $widgets['自定义'][$name] = array_merge($cfg[$name] ?? [], [
                'name' => $name,
                'fullname' => $name,
            ]);
        }

        foreach ($app->all() as $app) {
            $widgets[$app['name']] = [];
            $dir = $app['dir'] . '/src/widget';
            $cfg = Json::readFromFile($dir . '/config.json', []);
            foreach (glob($dir . '/*.php') as $file) {
                $name = substr($file, strlen($dir) + 1, -4);
                $widgets[$app['name']][$name] = array_merge($cfg[$name] ?? [], [
                    'name' => $name,
                    'fullname' => $name . '@' . $app['name'],
                ]);
            }
        }

        return $template->renderFromFile('widget/index@psrphp/admin', [
            'widgets' => $widgets,
        ]);
    }
}
