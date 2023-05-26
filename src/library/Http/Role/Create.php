<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Role;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Input;
use PsrPHP\Request\Request;

/**
 * 创建角色
 */
class Create extends Common
{
    public function get()
    {
        $form = new Builder('添加角色');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Input('角色名称', 'name'))
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
        $db->insert('psrphp_admin_role', [
            'name' => $request->post('name'),
        ]);
        return $this->success('操作成功！', null, 'javascript:history.go(-2)');
    }
}
