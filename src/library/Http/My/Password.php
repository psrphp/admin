<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\My;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Account;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Input;
use PsrPHP\Request\Request;

/**
 * 重置自己的密码
 */
class Password extends Common
{
    public function get()
    {
        $form = new Builder('修改密码');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-3'))->addItem(
                    new Input('原密码', 'oldpassword', '', [
                        'type' => 'password',
                        'required' => true,
                    ]),
                    new Input('新密码', 'password', '', [
                        'type' => 'password',
                        'required' => true,
                        'help' => '最少6位'
                    ])
                )
            )
        );
        return $form;
    }

    public function post(
        Request $request,
        Db $db,
        Account $account
    ) {
        $db->update('psrphp_admin_account', [
            'password' => Account::makePassword($request->post('password'))
        ], [
            'id' => $account->getAccountId(),
        ]);
        return Response::success('修改成功！');
    }
}
