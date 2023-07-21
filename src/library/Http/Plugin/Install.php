<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Plugin;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use Composer\Autoload\ClassLoader;
use Composer\InstalledVersions;
use PsrPHP\Request\Request;
use PsrPHP\Framework\Framework;
use ReflectionClass;

class Install extends Common
{
    public function post(
        Request $request
    ) {
        $name = $request->post('name');
        if (InstalledVersions::isInstalled($name)) {
            return Response::error('系统应用不支持该操作！');
        }
        $root = dirname(dirname(dirname((new ReflectionClass(InstalledVersions::class))->getFileName())));
        $install_lock = $root . '/config/' . $name . '/install.lock';
        if (file_exists($install_lock)) {
            return Response::error('已经安装，若要重装请先卸载！');
        }

        $loader = new ClassLoader();
        $loader->addPsr4(
            str_replace(['-', '/'], ['', '\\'], ucwords('App\\' . $name . '\\', '/\\-')),
            $root . '/' . $name . '/src/library/'
        );
        $loader->register();

        $cfgfile = getcwd() . '/vendor/' . $name . '/src/config/app.php';
        if (file_exists($cfgfile)) {
            $appcfg = self::requireFile($cfgfile);
            if (isset($appcfg['install']) && is_callable($appcfg['install'])) {
                Framework::execute($appcfg['install']);
            }
        }

        if (!is_dir(dirname($install_lock))) {
            mkdir(dirname($install_lock), 0755, true);
        }
        file_put_contents($install_lock, date(DATE_ATOM));

        return Response::success('操作成功！');
    }

    private static function requireFile(string $file)
    {
        static $loader;
        if (!$loader) {
            $loader = new class()
            {
                public function load(string $file)
                {
                    return require $file;
                }
            };
        }
        return $loader->load($file);
    }
}
