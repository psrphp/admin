{include common/header@psrphp/admin}
<h1>日志管理</h1>

<div>
    <form action="{:$router->build('/psrphp/admin/log/index')}" method="GET">
        <input type="search" name="q" value="{:$request->get('q')}" placeholder="搜索.." onchange="this.form.submit();">
        <input type="hidden" name="page" value="1">
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>账户</th>
            <th>操作节点</th>
            <th>方法</th>
            <th>IP</th>
            <th>时间</th>
            <th>提示</th>
            <th>详情</th>
        </tr>
    </thead>
    <tbody>
        {foreach $datas as $v}
        <tr>
            <td>{$v.id}</td>
            <td>
                {if $v['account_id']}
                <span>{$account->getName($v['account_id'])}</span>
                {else}
                <span>-</span>
                {/if}
            </td>
            <td>{$v.node}</td>
            <td>{$v.method}</td>
            <td>{$v.ip}</td>
            <td>{:date('Y-m-d H:i:s', $v['time'])}</td>
            <td>{$v.tips}</td>
            <td>
                <a href="{:$router->build('/psrphp/admin/log/detail', ['id'=>$v['id']])}">详情</a>
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