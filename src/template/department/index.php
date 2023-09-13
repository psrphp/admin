{include common/header@psrphp/admin}
<h1>组织结构管理</h1>
<div>
    <a href="{:$router->build('/psrphp/admin/department/create')}">创建部门</a>
    <a href="{:$router->build('/psrphp/admin/role/create')}">创建角色</a>
</div>

{function xx($departments, $router, $pid=0)}
{foreach $departments as $dep}
{if $dep['pid'] == $pid}
<details open>
    <summary>
        <span>{$dep['name']}</span>
        <a href="{:$router->build('/psrphp/admin/department/update', ['id'=>$dep['id']])}">编辑</a>
        <a href="{:$router->build('/psrphp/admin/department/delete', ['id'=>$dep['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
    </summary>
    <div style="margin-left: 18px;">
        {foreach $dep['roles'] as $role}
        <div>
            <span>✪</span>
            <span>{$role.name}</span>
            <a href="{:$router->build('/psrphp/admin/role/update', ['id'=>$role['id']])}">编辑</a>
            <a href="{:$router->build('/psrphp/admin/role/delete', ['id'=>$role['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
            <a href="{:$router->build('/psrphp/admin/role/auth', ['id'=>$role['id']])}">权限设置</a>
            <a href="{:$router->build('/psrphp/admin/role/account', ['id'=>$role['id']])}">成员({:count($role['accounts'])})</a>
        </div>
        {/foreach}
        {:xx($departments, $router, $dep['id'])}
    </div>
</details>
{/if}
{/foreach}
{/function}

<div style="margin-top: 10px;">
    {:xx($departments, $router)}
</div>

{include common/footer@psrphp/admin}