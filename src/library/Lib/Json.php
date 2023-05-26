<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Lib;

use Exception;

class Json
{

    public function read($file, $default = null)
    {
        if (!file_exists($file)) {
            return $default;
        }
        if (false === $res = file_get_contents($file)) {
            throw new Exception('can not read file [' . $file . '].');
        }

        $res = json_decode($res, true);

        if ($res === null) {
            throw new Exception('json文件无法被解码: [' . $file . '].');
        }

        return $res;
    }
}
