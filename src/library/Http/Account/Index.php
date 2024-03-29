<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Account;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;

/**
 * 查看账户
 */
class Index extends Common
{
    public function get(
        Db $db,
        Request $request,
        Template $template,
    ) {

        $data = [];
        $where = [];
        if ($request->get('state')) {
            $where['state'] = $request->get('state');
        }

        $total = $db->count('psrphp_admin_account', $where);
        $data['total'] = $total;

        $page = $request->get('page') ?: 1;
        $size = $request->get('size') ?: 20;
        $where['LIMIT'] = [($page - 1) * $size, $size];
        $where['ORDER'] = [
            'id' => 'ASC',
        ];
        $data['maxpage'] = ceil($total / $size) ?: 1;

        $roles = (function () use ($db) {
            $res = [];
            foreach ($db->select('psrphp_admin_role', '*') as $value) {
                $res[$value['id']] = $value;
            }
            return $res;
        })();
        $data['datas'] = (function () use ($db, $where, $roles): array {
            $datas = $db->select('psrphp_admin_account', '*', $where);
            foreach ($datas as &$value) {
                $value['roles'] = [];
                foreach ($db->select('psrphp_admin_account_role', 'role_id', [
                    'account_id' => $value['id'],
                ]) as $role_id) {
                    if (isset($roles[$role_id])) {
                        $value['roles'][] = $roles[$role_id];
                    }
                }
            }
            unset($value);
            return $datas;
        })();

        return $template->renderFromFile('account/index@psrphp/admin', $data);
    }
}
