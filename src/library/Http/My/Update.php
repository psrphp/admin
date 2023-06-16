<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\My;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Account;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Input;

/**
 * 修改账户基本信息
 */
class Update extends Common
{
    public function get(
        Account $account,
        Db $db
    ) {
        $account = $db->get('psrphp_admin_account', '*', [
            'id' => $account->getAccountId(),
        ]);
        $form = new Builder('修改账户基本信息');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-8'))->addItem(
                    (new Input('账户', 'name', $account['name']))
                )
            )
        );
        return $form;
    }

    public function post(
        Request $request,
        Account $account,
        Db $db
    ) {
        $account = $db->get('psrphp_admin_account', '*', [
            'id' => $account->getAccountId(),
        ]);
        if ($db->get('psrphp_admin_account', '*', [
            'name' => $request->post('name'),
            'id[!]' => $account['id'],
        ])) {
            return Response::error('账户重复！');
        }
        $update = array_intersect_key($request->post(), [
            'name' => '',
        ]);
        $db->update('psrphp_admin_account', $update, [
            'id' => $account['id'],
        ]);

        return Response::success('操作成功！', 'javascript:history.go(-2)');
    }
}
