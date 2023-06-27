<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Department;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;

/**
 * 删除部门
 */
class Delete extends Common
{
    public function get(
        Request $request,
        Db $db
    ) {
        if ($db->get('psrphp_admin_department', '*', [
            'pid' => $request->get('id'),
        ])) {
            return Response::error('请先删除子部门');
        }

        foreach ($db->select('psrphp_admin_role', '*', [
            'department_id' => $request->get('id'),
        ]) as $role) {
            $db->delete('psrphp_admin_account_role', [
                'role_id' => $role['id'],
            ]);
            $db->delete('psrphp_admin_auth', [
                'role_id' => $request->get('id'),
            ]);
        }
        $db->delete('psrphp_admin_role', [
            'department_id' => $request->get('id'),
        ]);
        $db->delete('psrphp_admin_department', [
            'id' => $request->get('id'),
        ]);
        return Response::success('操作成功！');
    }
}
