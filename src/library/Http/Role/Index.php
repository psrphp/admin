<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Role;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;

/**
 * 查看职位列表
 */
class Index extends Common
{
    public function get(
        Db $db,
        Request $request,
        Template $template
    ) {
        $data = [];
        $data['department'] = $db->get('psrphp_admin_department', '*', [
            'id' => $request->get('department_id'),
        ]);
        $data['roles'] = $db->select('psrphp_admin_role', '*', [
            'department_id' => $request->get('department_id'),
        ]);
        foreach ($data['roles'] as &$vo) {
            $vo['accounts'] = $db->select('psrphp_admin_account', '*', [
                'id' => $db->select('psrphp_admin_account_role', 'account_id', [
                    'role_id' => $vo['id']
                ]) ?: '_',
            ]);
        }
        return $template->renderFromFile('role/index@psrphp/admin', $data);
    }
}
