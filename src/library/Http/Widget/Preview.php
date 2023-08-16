<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Widget;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Json;
use Composer\Autoload\ClassLoader;
use PsrPHP\Framework\App;
use PsrPHP\Framework\Widget;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;
use ReflectionClass;

/**
 * 预览挂件
 */
class Preview extends Common
{
    public function get(
        App $app,
        Widget $widget,
        Request $request,
        Template $template
    ) {
        $fullname = $request->get('name');
        list($name, $pkg) = explode('@', $fullname . '@');
        if ($pkg) {
            $cfg = Json::readFromFile($app->get($pkg)['dir'] . '/src/widget/config.json', []);
            $code = file_get_contents($app->get($pkg)['dir'] . '/src/widget/' . $name . '.php');
        } else {
            $dir = dirname(dirname(dirname((new ReflectionClass(ClassLoader::class))->getFileName())));
            $cfg = Json::readFromFile($dir . '/widget/config.json', []);
            $code = file_get_contents($dir . '/widget/' . $name . '.php');
        }
        return $template->renderFromFile('widget/preview@psrphp/admin', array_merge($cfg[$name] ?? [], [
            'code' => $code,
            'res' => $widget->get($fullname),
        ]));
    }
}
