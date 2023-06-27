{include common/header@psrphp/admin}
<div class="my-4">
    <div class="h1">组织结构管理</div>
    <div class="text-muted fw-light">管理组织结构</div>
</div>
<div class="my-3">
    <a href="{:$router->build('/psrphp/admin/department/create')}" class="btn btn-primary">创建部门</a>
</div>

{function xx($departments, $router, $pid=0)}
{foreach $departments as $dep}
{if $dep['pid'] == $pid}
<details open>
    <summary>
        <span>{$dep['name']}</span>
        <a href="{:$router->build('/psrphp/admin/department/update', ['id'=>$dep['id']])}" class="link-primary text-decoration-none">编辑</a>
        <a href="{:$router->build('/psrphp/admin/department/delete', ['id'=>$dep['id']])}" class="link-primary text-decoration-none" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
        <a href="{:$router->build('/psrphp/admin/role/index', ['department_id'=>$dep['id']])}" class="link-primary text-decoration-none">职位成员</a>
    </summary>
    <div class="ms-4">
        {:xx($departments, $router, $dep['id'])}
    </div>
</details>
{/if}
{/foreach}
{/function}
{:xx($departments, $router)}
{include common/footer@psrphp/admin}