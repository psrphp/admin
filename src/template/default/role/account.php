{include common/header@psrphp/admin}
<h1>成员列表</h1>

<table style="margin-top: 10px;">
    <thead>
        <tr>
            <th>账户</th>
            <th>角色</th>
        </tr>
    </thead>
    <tbody>
        {foreach $accounts as $v}
        <tr>
            <td>{$v.name}</td>
            <td>
                {foreach $v['roles'] as $role}
                <span>[{$role.name}]</span>
                {/foreach}
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>

{include common/footer@psrphp/admin}