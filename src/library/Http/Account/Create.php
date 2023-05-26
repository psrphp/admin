<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Account;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Account;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Input;
use PsrPHP\Form\Field\Radio;
use PsrPHP\Request\Request;

/**
 * 添加账户
 */
class Create extends Common
{
    public function get()
    {
        $form = new Builder('添加账户');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Input('账户', 'name')),
                    (new Input('密码', 'password'))->set('type', 'password'),
                    (new Radio('状态', 'state', 1, [[
                        'label' => '允许登陆',
                        'value' => 1,
                    ], [
                        'label' => '禁止登陆',
                        'value' => 2,
                    ]]))
                ),
                (new Col('col-md-3'))->addItem()
            )
        );
        return $form;
    }

    public function post(
        Request $request,
        Db $db
    ) {
        $db->insert('psrphp_admin_account', [
            'name' => $request->post('name'),
            'password' => Account::makePassword(trim($request->post('password', '123456'))),
            'state' => $request->post('state', 1, ['intval']),
        ]);
        return Response::success('操作成功！', 'javascript:history.go(-2)');
    }
}
