<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Department;

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
                    (new Select('上级部门', 'pid', $department['pid'], (function () use ($db): array {
                        $departments = $db->select('psrphp_admin_department', '*');
                        $build = function ($data, $pid = 0, $level = 0) use (&$build): array {
                            $res = [];
                            foreach ($data as $value) {
                                if ($value['pid'] == $pid) {
                                    $value['_level'] = $level;
                                    array_unshift($res, $value, ...$build($data, $value['id'], $level + 1));
                                }
                            }
                            return $res;
                        };
                        $res = [];
                        $res[0] = '顶级';
                        foreach ($build($departments) as $value) {
                            $res[$value['id']] = str_repeat('ㅤ', $value['_level'] + 1) . '' . $value['name'];
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

        return Response::success('操作成功！', 'javascript:history.go(-2)');
    }
}
