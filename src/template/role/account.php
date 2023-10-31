{include common/header@psrphp/admin}
<h1>成员列表</h1>

<div class="table-responsive">
    <table class="table table-bordered mb-0 d-table-cell">
        <thead>
            <tr>
                <th>账户</th>
                <th>角色</th>
            </tr>
        </thead>
        <tbody>
            {foreach $accounts as $v}
            <tr>
                <td class="text-nowrap">{$v.name}</td>
                <td class="text-nowrap">
                    {foreach $v['roles'] as $role}
                    <span>[{$role.name}]</span>
                    {/foreach}
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>

{include common/footer@psrphp/admin}