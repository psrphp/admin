<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Theme;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Request\Request;
use PsrPHP\Framework\Config;

class Down extends Common
{
    public function post(
        Request $request,
        Config $config
    ) {
        $name = $request->post('name');

        if (!preg_match('/^[a-zA-Z0-9]+$/u', $name)) {
            return Response::error('参数错误！');
        }

        $theme = $config->get('theme', []);

        $key = array_search($name, $theme);
        if ($key === false) {
            return Response::error('参数错误！');
        }
        $tmp = $theme[$key + 1];
        $theme[$key + 1] = $name;
        $theme[$key] = $tmp;
        $config->save('theme', array_values($theme));

        return Response::success('操作成功！');
    }
}
