<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Cache;

use App\Psrphp\Admin\Http\Common;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * 清理系统缓存
 */
class Clear extends Common
{
    public function get(
        CacheInterface $cache
    ): ResponseInterface {
        if ($cache->clear()) {
            return $this->success('清理成功！');
        }
        return $this->error('清理失败！');
    }
}
