<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Account;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;

/**
 * 角色设置
 */
class Role extends Common
{
    public function get(
        Db $db,
        Request $request,
        Template $template,
    ) {
        $account = $db->get('psrphp_admin_account', '*', [
            'id' => $request->get('id'),
        ]);
        $data = [];
        $departments = $db->select('psrphp_admin_department', '*');
        foreach ($departments as &$vo) {
            $vo['roles'] = $db->select('psrphp_admin_role', '*', [
                'department_id' => $vo['id'],
            ]);
        }
        $data['departments'] = $departments;
        $data['role_ids'] = $db->select('psrphp_admin_account_role', 'role_id', [
            'account_id' => $account['id'],
        ]);
        $data['account'] =  $account;
        return $template->renderFromFile('account/role@psrphp/admin', $data);
    }

    public function post(
        Db $db,
        Request $request,
    ) {
        $account = $db->get('psrphp_admin_account', '*', [
            'id' => $request->post('account_id'),
        ]);

        $db->delete('psrphp_admin_account_role', [
            'account_id' => $account['id'],
        ]);

        $res = [];
        foreach ($request->post('role_ids', []) as $vo) {
            $res[] = [
                'account_id' => $account['id'],
                'role_id' => $vo,
            ];
        }
        $db->insert('psrphp_admin_account_role', $res);

        return Response::success('操作成功！', null, 'javascript:history.go(-2)');
    }
}
