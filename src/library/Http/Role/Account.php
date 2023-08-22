<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Role;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;

/**
 * 查看指定角色的成员列表
 */
class Account extends Common
{
    public function get(
        Db $db,
        Request $request,
        Template $template
    ) {
        $role = $db->get('psrphp_admin_role', '*', [
            'id' => $request->get('id'),
        ]);
        $accounts = [];
        if ($ids = $db->select('psrphp_admin_account_role', 'account_id', [
            'role_id' => $role['id'],
        ])) {
            $accounts = $db->select('psrphp_admin_account', '*', [
                'id' => $ids,
            ]);
            foreach ($accounts as &$vo) {
                $vo['roles'] = [];
                foreach ($db->select('psrphp_admin_account_role', 'role_id', [
                    'account_id' => $vo['id'],
                ]) as $role_id) {
                    $vo['roles'][] = $db->get('psrphp_admin_role', '*', [
                        'id' => $role_id,
                    ]);
                }
            }
        }
        return $template->renderFromFile('role/account@psrphp/admin', [
            'role' => $role,
            'accounts' => $accounts,
        ]);
    }
}
