<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Role;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Col;
use PsrPHP\Form\Row;
use PsrPHP\Form\Input;
use PsrPHP\Form\SelectLevel;
use PsrPHP\Request\Request;

/**
 * 创建角色
 */
class Create extends Common
{
    public function get(
        Db $db
    ) {
        $form = new Builder('添加角色');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new SelectLevel('所属部门', 'department_id', null, (function () use ($db): array {
                        $res = [];
                        foreach ($db->select('psrphp_admin_department', '*') as $vo) {
                            $res[] = [
                                'value' => $vo['id'],
                                'parent' => $vo['pid'] ?: null,
                                'title' => $vo['name'],
                            ];
                        }
                        return $res;
                    })())),
                    (new Input('角色名称', 'name')),
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
            'department_id' => $request->post('department_id'),
            'name' => $request->post('name'),
        ]);
        return Response::success('操作成功！', null, 'javascript:history.go(-2)');
    }
}
