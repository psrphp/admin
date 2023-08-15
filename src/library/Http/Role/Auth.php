<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Role;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Html;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Hidden;
use PsrPHP\Form\Field\Input;
use PsrPHP\Framework\App;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;
use ReflectionClass;

/**
 * 给职位设置权限
 */
class Auth extends Common
{
    public function get(
        Db $db,
        App $app,
        Request $request,
        Template $template
    ) {
        $role = $db->get('psrphp_admin_role', '*', [
            'id' => $request->get('id', 0, ['intval']),
        ]);
        $form = new Builder('设置权限');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-8'))->addItem(
                    (new Hidden('id', $role['id'])),
                    (new Input('职位名称', 'name', $role['name']))->set('disabled', true),
                    (new Html((function () use ($db, $app, $template, $role): string {
                        $nodes = [];
                        foreach ($app->all() as $app) {
                            if ($tmp = $this->getNodesByApp($app)) {
                                $nodes[$app['name']] = $tmp;
                            }
                        }
                        $values = $db->select('psrphp_admin_auth', 'node', [
                            'role_id' => $role['id'],
                        ]);
                        $tpl = <<<'str'
<div>
    <div>权限设置</div>
    <div>
        {foreach $nodes as $appname => $vos}
            <details open>
            <summary>{$appname}</summary>
            {foreach $vos as $appname => $vo}
            <div>
                <label>
                    <input type="checkbox" name="nodes[]" id="field_{:md5('nodes~'. $vo['node'])}" value="{$vo['node']}" {:in_array($vo['node'], $values)?'checked':''}>
                    <span title="{$vo.doc}">{$vo.node}</span>
                </label>
            </div>
            {/foreach}
            </details>
        {/foreach}
    </div>
</div>
str;
                        return $template->renderFromString($tpl, [
                            'nodes' => $nodes,
                            'values' => $values,
                        ]);
                    })()))
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

        $db->delete('psrphp_admin_auth', [
            'role_id' => $role['id'],
        ]);
        if ($request->post('nodes')) {
            $nodes = [];
            foreach ($request->post('nodes') as $node) {
                $nodes[] = [
                    'role_id' => $role['id'],
                    'node' => $node,
                ];
            }
            $db->insert('psrphp_admin_auth', $nodes);
        }

        return Response::success('操作成功！', null, 'javascript:history.go(-2)');
    }

    private function getNodesByApp(array $app): array
    {
        $nodes = [];
        $base = $app['dir'] . '/src/library/Http';
        if (!is_dir($base)) {
            return $nodes;
        }
        $files = $this->getFileList($base);
        foreach ($files as $file) {
            if (substr($file, -4) != '.php') {
                continue;
            }
            $cls = str_replace(['-', '/'], ['', '\\'], ucwords('App\\' . $app['name'] . '\\Http' . substr($file, strlen($base), -4), '/\\-'));
            $rfc = (new ReflectionClass($cls));
            if (!$rfc->isInstantiable()) {
                continue;
            }
            if (!$rfc->isSubclassOf(Common::class)) {
                continue;
            }
            $nodes[] = [
                'node' => $cls,
                'doc' => $rfc->getDocComment(),
            ];
        }
        return $nodes;
    }

    private function getFileList($dir): array
    {
        $file_list = [];
        $file_dir_list = [];

        $dir_list = scandir($dir);

        foreach ($dir_list as $r) {
            if ($r == '.' || $r == '..') {
                continue;
            }
            $new_dir = $dir . DIRECTORY_SEPARATOR . $r;
            if (is_dir($new_dir)) {
                $file_dir = $this->getFileList($new_dir);
                $file_dir_list = array_merge($file_dir_list, $file_dir);
            } else {
                $file_list[] = $new_dir;
            }
        }

        return array_merge($file_list, $file_dir_list);
    }
}
