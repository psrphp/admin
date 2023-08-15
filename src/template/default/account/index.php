{include common/header@psrphp/admin}
<h1>账户管理</h1>
<div>
    <a href="{:$router->build('/psrphp/admin/account/create')}">创建账户</a>
</div>

<form action="{:$router->build('/psrphp/admin/account/index')}" method="GET">
    <input type="hidden" name="page" value="1">
    <select name="state" onchange="this.form.submit();">
        <option {if $request->get('state')=='' }selected{/if} value="">不限</option>
        <option {if $request->get('state')=='1' }selected{/if} value="1">允许登陆</option>
        <option {if $request->get('state')=='2' }selected{/if} value="2">禁止登陆</option>
    </select>
    <input type="search" name="q" value="{:$request->get('q')}" placeholder="搜索.." onchange="this.form.submit();">
</form>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>账户</th>
            <th>状态</th>
            <th>职位</th>
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
                {foreach $v['roles'] as $role}
                <span>[{$role.name}]</span>
                {/foreach}
            </td>
            <td>
                {if $v['id']!=1}
                <a href="{:$router->build('/psrphp/admin/account/role', ['id'=>$v['id']])}">职位设置</a>
                <a href="{:$router->build('/psrphp/admin/account/name', ['id'=>$v['id']])}">设置账户名</a>
                <a href="{:$router->build('/psrphp/admin/account/state', ['id'=>$v['id']])}">设置状态</a>
                <a href="{:$router->build('/psrphp/admin/account/password', ['id'=>$v['id']])}">重置密码</a>
                <a href="{:$router->build('/psrphp/admin/account/delete', ['id'=>$v['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
                {else}
                <span>超级管理员</span>
                {/if}
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>

<div style="display: flex;flex-direction: row;flex-wrap: wrap;">
    <form>
        <button type="submit" name="page" value="1">首页</button>
        <button type="submit" name="page" value="{:max($request->get('page')-1, 1)}">上一页</button>
    </form>
    <form style="margin:0 5px;">
        <input type="number" name="page" min="1" max="{$maxpage}" step="1" style="width:50px" value="{:$request->get('page', 1)}" onchange="event.target.form.submit()">
    </form>
    <form>
        <button type="submit" name="page" value="{:min($request->get('page')+1, $maxpage)}">下一页</button>
        <button type="submit" name="page" value="{$maxpage}">末页</button>
    </form>
</div>

{include common/footer@psrphp/admin}