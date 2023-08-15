{include common/header@psrphp/admin}
<h1>职位设置</h1>

{function xx($departments, $role_ids, $router, $pid=0)}
{foreach $departments as $dep}
{if $dep['pid'] == $pid}
<details open>
    <summary>
        <span>{$dep['name']}</span>
    </summary>
    <div style="margin-left: 18px;">
        {foreach $dep['roles'] as $role}
        <div>
            <label>
                {if in_array($role['id'], $role_ids)}
                <input type="checkbox" name="role_ids[]" value="{$role.id}" checked>
                {else}
                <input type="checkbox" name="role_ids[]" value="{$role.id}">
                {/if}
                <span>{$role.name}</span>
            </label>
            <span></span>
        </div>
        {/foreach}
        {:xx($departments, $role_ids, $router, $dep['id'])}
    </div>
</details>
{/if}
{/foreach}
{/function}
<form method="post">
    {:xx($departments, $role_ids, $router)}
    <input type="hidden" name="account_id" value="{$account.id}">
    <div>
        <button type="submit">提交</button>
    </div>
</form>
{include common/footer@psrphp/admin}