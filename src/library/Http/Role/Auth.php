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
use PsrPHP\Framework\Framework;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;
use ReflectionClass;

/**
 * 给职位设置权限
 */
class Auth extends Common
{
    public function get(
        Request $request,
        Template $template,
        Db $db
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
                    (new Html((function () use ($db, $template, $role): string {
                        $nodes = [];
                        foreach (Framework::getAppList() as $app) {
                            if ($tmp = $this->getNodesByApp($app)) {
                                $nodes[$app['name']] = $tmp;
                            }
                        }
                        $values = $db->select('psrphp_admin_auth', 'node', [
                            'role_id' => $role['id'],
                        ]);
                        $tpl = <<<'str'
<div class="mt-2">
    <label class="form-label">权限设置</label>
    <div>
        {foreach $nodes as $appname => $vos}
            <details open>
            <summary class="fs-6">{$appname}</summary>
            <div class="ml-3 mt-1">
                {foreach $vos as $appname => $vo}
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input class="custom-control-input" type="checkbox" name="nodes[]" id="field_{:md5('nodes~'. $vo['node'])}" value="{$vo['node']}" {:in_array($vo['node'], $values)?'checked':''}>
                    {if $vo['doc']}
                    <label class="custom-control-label" for="field_{:md5('nodes~'. $vo['node'])}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="<pre class='text-start mb-0'>{$vo.doc}</pre>">{$vo.node}</label>
                    {else}
                    <label class="custom-control-label" for="field_{:md5('nodes~'. $vo['node'])}">{$vo.node}</label>
                    {/if}
                </div>
                {/foreach}
            </div>
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

        return Response::success('操作成功！', 'javascript:history.go(-2)');
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
