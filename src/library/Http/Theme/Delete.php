<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Theme;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Dir;
use App\Psrphp\Admin\Lib\Response;
use Composer\InstalledVersions;
use PsrPHP\Framework\Config;
use PsrPHP\Request\Request;
use ReflectionClass;

class Delete extends Common
{
    public function post(
        Request $request,
        Config $config,
        Dir $dir
    ) {
        $name = $request->post('name');

        if (!preg_match('/^[a-zA-Z0-9]+$/u', $name)) {
            return Response::error('参数错误！');
        }

        $root = dirname(dirname(dirname((new ReflectionClass(InstalledVersions::class))->getFileName())));
        $dir->del($root . '/theme/' . $name);

        $theme = $config->get('theme', []);
        $key = array_search($name, $theme);
        if ($key !== false) {
            unset($theme[$key]);
        }
        $config->save('theme', array_values($theme));

        return Response::success('操作成功！');
    }
}
