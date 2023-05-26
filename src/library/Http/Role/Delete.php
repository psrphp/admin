<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Role;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;

/**
 * 删除角色
 */
class Delete extends Common
{
    public function get(
        Request $request,
        Db $db
    ) {
        $db->delete('psrphp_admin_role', [
            'id' => $request->get('id'),
        ]);
        $db->delete('psrphp_admin_account_role', [
            'role_id' => $request->get('id'),
        ]);
        $db->delete('psrphp_admin_role_node', [
            'role_id' => $request->get('id'),
        ]);
        return $this->success('操作成功！');
    }
}
