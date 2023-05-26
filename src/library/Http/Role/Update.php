<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Role;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Hidden;
use PsrPHP\Form\Field\Input;
use PsrPHP\Request\Request;

/**
 * 编辑角色信息
 */
class Update extends Common
{
    public function get(
        Request $request,
        Db $db
    ) {
        $role = $db->get('psrphp_admin_role', '*', [
            'id' => $request->get('id', 0, ['intval']),
        ]);
        $form = new Builder('编辑角色');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-8'))->addItem(
                    (new Hidden('id', $role['id'])),
                    (new Input('角色名称', 'name', $role['name']))
                )
            )
        );
        return $form;
    }

    public function post(
        Request $request,
        Db $db
    ) {
        $role = $db->get('psrphp_admin_role', '*', [
            'id' => $request->post('id', 0, ['intval']),
        ]);

        $update = array_intersect_key($request->post(), [
            'name' => '',
        ]);

        $db->update('psrphp_admin_role', $update, [
            'id' => $role['id'],
        ]);

        return Response::success('操作成功！', 'javascript:history.go(-2)');
    }
}
