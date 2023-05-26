<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Auth;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Model\Account;
use Psr\Http\Message\ResponseInterface;

/**
 * 退出后台
 */
class Logout extends Common
{
    public function get(
        Account $account
    ): ResponseInterface {
        if ($account->logout()) {
            return $this->success('已退出');
        } else {
            return $this->error('操作失败！');
        }
    }
}
