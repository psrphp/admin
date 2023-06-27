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
 * 创建职位
 */
class Create extends Common
{
    public function get(
        Request $request
    ) {
        $form = new Builder('添加职位');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Hidden('department_id', $request->get('department_id'))),
                    (new Input('职位名称', 'name')),
                    (new Select('类型', 'director', 0, [
                        '1' => '主管',
                        '2' => '副主管',
                        '0' => '普通成员',
                    ]))
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
            'director' => $request->post('director'),
        ]);
        return Response::success('操作成功！', null, 'javascript:history.go(-2)');
    }
}
