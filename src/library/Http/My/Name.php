<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\My;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Auth;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Hidden;
use PsrPHP\Form\Field\Input;

/**
 * 修改自己的账户名
 */
class Name extends Common
{
    public function get(
        Auth $auth,
        Db $db
    ) {
        $account = $db->get('psrphp_admin_account', '*', [
            'id' => $auth->getId(),
        ]);
        $form = new Builder('修改账户名');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-8'))->addItem(
                    (new Hidden('id', $account['id'])),
                    (new Input('账户', 'name', $account['name']))
                )
            )
        );
        return $form;
    }

    public function post(
        Request $request,
        Auth $auth,
        Db $db
    ) {
        $account = $db->get('psrphp_admin_account', '*', [
            'id' => $auth->getId(),
        ]);

        if ($db->get('psrphp_admin_account', '*', [
            'id[!]' => $account['id'],
            'name' => $request->post('name'),
        ])) {
            return Response::error('账户名重复~');
        }

        $db->update('psrphp_admin_account', [
            'name' => $request->post('name'),
        ], [
            'id' => $account['id'],
        ]);

        return Response::success('操作成功！', 'javascript:history.go(-2)');
    }
}
