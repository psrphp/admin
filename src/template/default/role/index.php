{include common/header@psrphp/admin}
<div class="my-4">
    <div class="h1">角色管理</div>
    <div class="text-muted fw-light">管理后台角色</div>
</div>

<div class="my-3">
    <a href="{:$router->build('/psrphp/admin/role/create')}" class="btn btn-primary">创建角色</a>
</div>

<div class="table-responsive my-3">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>角色名称</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            {foreach $datas as $v}
            <tr>
                <td>{$v.name}</td>
                <td>
                    <a href="{:$router->build('/psrphp/admin/role/update', ['id'=>$v['id']])}">编辑</a>
                    <a href="{:$router->build('/psrphp/admin/role/node', ['id'=>$v['id']])}">设置权限</a>
                    <a href="{:$router->build('/psrphp/admin/role/delete', ['id'=>$v['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>
{include common/footer@psrphp/admin}