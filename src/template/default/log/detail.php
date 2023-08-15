{include common/header@psrphp/admin}
<h1>日志详情</h1>

<style>
    dt {
        font-weight: bold;
    }
</style>

<dl>
    <dt>id</dt>
    <dd>{$log.id}</dd>

    <dt>account</dt>
    <dd>
        {if $log['account_id']}
        <span>{$account->getName($log['account_id'])}</span>
        {else}
        <span>-</span>
        {/if}
    </dd>

    <dt>tips</dt>
    <dd>{$log.tips}</dd>

    <dt>method</dt>
    <dd>{$log.method}</dd>

    <dt>ip</dt>
    <dd>{$log.ip}</dd>

    <dt>time</dt>
    <dd>{:date('Y-m-d H:i:s', $log['time'])}</dd>

    <dt>data</dt>
    <dd>
        <code style="word-break: break-word;width: 100%;white-space: pre-wrap;">{php}print_r(json_decode($log['data'], true));{/php}</code>
    </dd>
</dl>
{include common/footer@psrphp/admin}