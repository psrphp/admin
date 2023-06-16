{include common/header@psrphp/admin}
<div class="my-4">
    <div class="h1">日志管理</div>
    <div class="text-muted fw-light">管理后台账户操作日志</div>
</div>

<div class="my-3">
    <form id="form_filter" class="row gy-2 gx-3 align-items-center" action="{:$router->build('/psrphp/admin/log/index')}" method="GET">

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
                    <span>{:$db->get('psrphp_admin_account', 'name', ['id'=>$v['account_id']])}</span>
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
</div>
<nav>
    <ul class="pagination">
        {foreach $pages as $v}
        {if $v=='...'}
        <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">{$v}</a></li>
        {elseif isset($v['current'])}
        <li class="page-item active"><a class="page-link" href="javascript:void(0);">{$v.page}</a></li>
        {else}
        <li class="page-item"><a class="page-link" href="{:$router->build('/psrphp/admin/log/index', array_merge($_GET, ['page'=>$v['page']]))}">{$v.page}</a></li>
        {/if}
        {/foreach}
    </ul>
</nav>
{include common/footer@psrphp/admin}