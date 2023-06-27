<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Widget;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Json;
use Composer\InstalledVersions;
use PsrPHP\Framework\Framework;
use PsrPHP\Template\Template;
use ReflectionClass;

/**
 * 查看所有挂件
 */
class Index extends Common
{
    public function get(
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
                'tips' => $cfg[$name]['tips'] ?? '',
                'fullname' => $name,
            ];
        }

        foreach (Framework::getAppList() as $app) {
            $widgets[$app['name']] = [];
            $dir = $app['dir'] . '/src/widget';
            $cfg = Json::readFromFile($dir . '/config.json', []);
            foreach (glob($dir . '/*.php') as $file) {
                $name = substr($file, strlen($dir) + 1, -4);
                $widgets[$app['name']][$name] = [
                    'name' => $name,
                    'tips' => $cfg[$name]['tips'] ?? '',
                    'fullname' => $name . '@' . $app['name'],
                ];
            }
        }

        return $template->renderFromFile('widget/index@psrphp/admin', [
            'widgets' => $widgets,
        ]);
    }
}
