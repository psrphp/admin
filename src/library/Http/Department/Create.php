<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Department;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Input;
use PsrPHP\Form\Field\Select;
use PsrPHP\Request\Request;

/**
 * 创建部门
 */
class Create extends Common
{
    public function get(
        Db $db
    ) {
        $form = new Builder('添加部门');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    new Select('上级部门', 'pid', 0, (function () use ($db): array {
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
                    })()),
                    (new Input('部门名称', 'name'))
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
        $db->insert('psrphp_admin_department', [
            'pid' => $request->post('pid', 0),
            'name' => $request->post('name'),
        ]);
        return Response::success('操作成功！', null, 'javascript:history.go(-2)');
    }
}
