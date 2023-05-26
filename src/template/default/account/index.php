{include common/header@psrphp/admin}
<div class="my-4">
    <div class="h1">账户管理</div>
    <div class="text-muted fw-light">管理后台账户</div>
</div>
<div class="my-3">
    <a href="{:$router->build('/psrphp/admin/account/create')}" class="btn btn-primary">创建账户</a>
</div>

<div class="my-3">
    <form id="form_filter" class="row gy-2 gx-3 align-items-center" action="{:$router->build('/psrphp/admin/account/index')}" method="GET">

        <div class="col-auto">
            <label class="visually-hidden">分页</label>
            <select class="form-select" name="page_num" onchange="document.getElementById('form_filter').submit();">
                <option {if $request->get('page_num')=='20' }selected{/if} value="20">20</option>
                <option {if $request->get('page_num')=='50' }selected{/if} value="50">50</option>
                <option {if $request->get('page_num')=='100' }selected{/if} value="100">100</option>
                <option {if $request->get('page_num')=='500' }selected{/if} value="500">500</option>
            </select>
        </div>

        <div class="col-auto">
            <label class="visually-hidden">状态</label>
            <select class="form-select" name="state" onchange="document.getElementById('form_filter').submit();">
                <option {if $request->get('state')=='' }selected{/if} value="">不限</option>
                <option {if $request->get('state')=='1' }selected{/if} value="1">允许登陆</option>
                <option {if $request->get('state')=='2' }selected{/if} value="2">禁止登陆</option>
            </select>
        </div>

        <div class="col-auto">
            <label class="visually-hidden">搜索</label>
            <input type="search" class="form-control" name="q" value="{:$request->get('q')}" placeholder="搜索.." onchange="document.getElementById('form_filter').submit();">
        </div>
        <input type="hidden" name="page" value="1">
    </form>
</div>

<div class="table-responsive my-3">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>账户</th>
                <th>状态</th>
                <th>角色</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            {foreach $datas as $v}
            <tr>
                <td>{$v.id}</td>
                <td>{$v.name}</td>
                <td>{:$v['state']==1?'允许登陆':'禁止登陆'}</td>
                <td>
                    {if $v['id']==1}
                    <span class="badge bg-danger">超级管理员</span>
                    {else}
                    {foreach $v['roles'] as $role}
                    <span class="badge bg-primary">{$role.name}</span>
                    {/foreach}
                    {/if}
                </td>
                <td>
                    <a href="{:$router->build('/psrphp/admin/account/update', ['id'=>$v['id']])}">编辑</a>
                    <a href="{:$router->build('/psrphp/admin/account/role', ['id'=>$v['id']])}">设置角色</a>
                    <a href="{:$router->build('/psrphp/admin/account/password', ['id'=>$v['id']])}">重置密码</a>
                    <a href="{:$router->build('/psrphp/admin/account/state', ['id'=>$v['id']])}">设置状态</a>
                    <a href="{:$router->build('/psrphp/admin/account/delete', ['id'=>$v['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>
<nav>
    <ul class="pagination">
        {foreach $pages as $v}
        {if $v=='...'}
        <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">{$v}</a></li>
        {elseif isset($v['current'])}
        <li class="page-item active"><a class="page-link" href="javascript:void(0);">{$v.page}</a></li>
        {else}
        <li class="page-item"><a class="page-link" href="{:$router->build('/psrphp/admin/account/index', array_merge($_GET, ['page'=>$v['page']]))}">{$v.page}</a></li>
        {/if}
        {/foreach}
    </ul>
</nav>
{include common/footer@psrphp/admin}