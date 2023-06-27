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
use PsrPHP\Form\Field\Select;
use PsrPHP\Request\Request;

/**
 * 编辑职位信息
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
        $form = new Builder('编辑职位');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-8'))->addItem(
                    (new Hidden('id', $role['id'])),
                    (new Input('职位名称', 'name', $role['name'])),
                    (new Select('类型', 'director', $role['director'], [
                        '1' => '主管',
                        '2' => '副主管',
                        '0' => '普通成员',
                    ]))
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
            'director' => '',
        ]);

        $db->update('psrphp_admin_role', $update, [
            'id' => $role['id'],
        ]);

        return Response::success('操作成功！', 'javascript:history.go(-2)');
    }
}
