<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\My;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Col;
use PsrPHP\Form\Row;
use PsrPHP\Form\Input;
use PsrPHP\Request\Request;
use Throwable;

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
                    (new Input('原密码', 'old'))->setRequired(),
                    (new Input('新密码', 'new1'))->setHelp('最少6位')->setRequired(),
                    (new Input('重复新密码', 'new2'))->setHelp('再次输入新密码，防止输错')->setRequired()
                )
            )
        );
        return $form;
    }

    public function post(
        Request $request,
        Auth $auth,
        Account $account
    ) {
        if ($request->post('new1', '1') != $request->post('new2', '2')) {
            return Response::error('两次密码输入不一致~');
        }
        if (!$account->checkPassword($auth->getId(), trim($request->post('old')))) {
            return Response::error('原密码不正确~');
        }
        try {
            $account->setPassword($auth->getId(), trim($request->post('new1')));
        } catch (Throwable $th) {
            return Response::error($th->getMessage());
        }
        return Response::success('修改成功！');
    }
}
