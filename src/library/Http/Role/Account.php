<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Role;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;

/**
 * 管理职位成员
 */
class Account extends Common
{
    public function get(
        Request $request,
        Db $db
    ) {
        if ($db->get('psrphp_admin_account_role', '*', [
            'role_id' => $request->get('role_id'),
            'account_id' => $request->get('account_id'),
        ])) {
            $db->delete('psrphp_admin_account_role', [
                'role_id' => $request->get('role_id'),
                'account_id' => $request->get('account_id'),
            ]);
        } else {
            $db->insert('psrphp_admin_account_role', [
                'role_id' => $request->get('role_id'),
                'account_id' => $request->get('account_id'),
            ]);
        }
        return Response::success('操作成功！');
    }

    public function post(
        Db $db,
        Request $request,
        Template $template
    ) {
        $tpl = <<<'str'
<div class="table-responsive my-3">
    <table class="table table-bordered">
        <tbody>
            {foreach $accounts as $v}
            <tr>
                <td>{$v.name}</td>
                <td>
                    <a href="{:$router->build('/psrphp/admin/role/account', ['role_id'=>$request->post('role_id'), 'account_id'=>$v['id']])}">添加</a>
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>
str;
        return Response::success('成功', $template->renderFromString($tpl, [
            'accounts' => $db->select('psrphp_admin_account', '*', [
                'name[~]' => '%' . $request->post('q') . '%',
                'LIMIT' => 10,
            ])
        ]));
    }
}
