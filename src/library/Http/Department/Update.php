<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Department;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Col;
use PsrPHP\Form\Row;
use PsrPHP\Form\Input;
use PsrPHP\Form\Hidden;
use PsrPHP\Form\SelectLevel;
use PsrPHP\Request\Request;

/**
 * 编辑部门信息
 */
class Update extends Common
{
    public function get(
        Request $request,
        Db $db
    ) {
        $department = $db->get('psrphp_admin_department', '*', [
            'id' => $request->get('id', 0),
        ]);
        $form = new Builder('编辑部门');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-8'))->addItem(
                    (new Hidden('id', $department['id'])),
                    (new SelectLevel('上级部门', 'pid', $department['pid'], (function () use ($db): array {
                        $res = [];
                        foreach ($db->select('psrphp_admin_department', '*') as $vo) {
                            $res[] = [
                                'value' => $vo['id'],
                                'parent' => $vo['pid'] ?: null,
                                'title' => $vo['name']
                            ];
                        }
                        return $res;
                    })())),
                    (new Input('部门名称', 'name', $department['name']))
                )
            )
        );
        return $form;
    }

    public function post(
        Request $request,
        Db $db
    ) {
        $role = $db->get('psrphp_admin_department', '*', [
            'id' => $request->post('id', 0),
        ]);

        $update = array_intersect_key($request->post(), [
            'pid' => '',
            'name' => '',
        ]);

        $db->update('psrphp_admin_department', $update, [
            'id' => $role['id'],
        ]);

        return Response::success('操作成功！', null, 'javascript:history.go(-2)');
    }
}
