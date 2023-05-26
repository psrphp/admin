<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Account;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Checkbox;
use PsrPHP\Form\Field\Hidden;
use PsrPHP\Form\Field\Input;

/**
 * 给账户设置角色
 */
class Role extends Common
{
    public function get(
        Request $request,
        Db $db
    ) {
        $account = $db->get('psrphp_admin_account', '*', [
            'id' => $request->get('id', 0, ['intval']),
        ]);
        if ($account['id'] == 1) {
            return $this->error('不支持对超级管理员进行该操作~');
        }
        $form = new Builder('给账户设置角色');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-8'))->addItem(
                    (new Hidden('id', $account['id'])),
                    (new Input('账户', 'name', $account['name']))->set('disabled', true),
                    (new Checkbox('角色', 'role_ids', (function () use ($db, $account): array {
                        return $db->select('psrphp_admin_account_role', 'role_id', [
                            'account_id' => $account['id'],
                        ]);
                    })(), (function () use ($db): array {
                        $res = [];
                        $roles = $db->select('psrphp_admin_role', '*', [
                            'ORDER' => [
                                'id' => 'ASC',
                            ],
                        ]);
                        foreach ($roles as $value) {
                            $res[] = [
                                'label' => $value['name'],
                                'value' => $value['id'],
                            ];
                        }
                        return $res;
                    })()))
                )
            )
        );
        return $form;
    }

    public function post(
        Request $request,
        Db $db
    ) {
        $account = $db->get('psrphp_admin_account', '*', [
            'id' => $request->post('id', 0, ['intval']),
        ]);
        if ($account['id'] == 1) {
            return $this->error('不支持对超级管理员进行该操作~');
        }

        $db->delete('psrphp_admin_account_role', [
            'account_id' => $account['id'],
        ]);

        if ($request->post('role_ids')) {
            $account_roles = [];
            foreach ($request->post('role_ids') as $value) {
                $account_roles[] = [
                    'account_id' => $account['id'],
                    'role_id' => $value,
                ];
            }
            $db->insert('psrphp_admin_account_role', $account_roles);
        }

        return $this->success('操作成功！', 'javascript:history.go(-2)');
    }
}
