<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Account;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;

/**
 * 删除账户
 */
class Delete extends Common
{
    public function get(
        Request $request,
        Db $db
    ) {
        if ($request->get('id') == '1') {
            return Response::error('超级管理员不允许删除！');
        }
        $db->delete('psrphp_admin_account', [
            'id' => $request->get('id'),
        ]);
        $db->delete('psrphp_admin_account_role', [
            'account_id' => $request->get('id'),
        ]);
        return Response::success('操作成功！');
    }
}
