<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Department;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Database\Db;
use PsrPHP\Template\Template;

/**
 * 查看组织结构
 */
class Index extends Common
{
    public function get(
        Db $db,
        Template $template
    ) {
        $data = [];
        $departments = $db->select('psrphp_admin_department', '*');
        foreach ($departments as &$vo) {
            $roles = $db->select('psrphp_admin_role', '*', [
                'department_id' => $vo['id'],
            ]);
            foreach ($roles as &$ro) {
                $ro['accounts'] = [];
                if ($ids = $db->select('psrphp_admin_account_role', 'account_id', [
                    'role_id' => $ro['id'],
                ])) {
                    $ro['accounts'] = $db->select('psrphp_admin_account', '*', [
                        'id' => $ids,
                    ]);
                }
            }
            $vo['roles'] = $roles;
        }
        $data['departments'] = $departments;
        return $template->renderFromFile('department/index@psrphp/admin', $data);
    }
}
