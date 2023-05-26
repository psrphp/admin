<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Account;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Hidden;
use PsrPHP\Form\Field\Input;

/**
 * 设置账户基本信息
 */
class Update extends Common
{
    public function get(
        Request $request,
        Db $db
    ) {
        $account = $db->get('psrphp_admin_account', '*', [
            'id' => $request->get('id', 0, ['intval']),
        ]);
        if ($account['id'] == 1) {
            return Response::error('不支持对超级管理员进行该操作~');
        }
        $form = new Builder('设置账户基本信息');
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
        Db $db
    ) {
        $account = $db->get('psrphp_admin_account', '*', [
            'id' => $request->post('id', 0, ['intval']),
        ]);
        if ($account['id'] == 1) {
            return Response::error('不支持对超级管理员进行该操作~');
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
