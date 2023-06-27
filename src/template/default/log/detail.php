{include common/header@psrphp/admin}
<div class="my-4">
    <div class="h1">日志管理</div>
    <div class="text-muted fw-light">管理后台账户操作日志</div>
</div>

<div class="table-responsive my-3">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>id</th>
                <td>{$log.id}</td>
            </tr>
            <tr>
                <th>account</th>
                <td>
                    {if $log['account_id']}
                    <span>{$account->getName($log['account_id'])}</span>
                    {else}
                    <span>-</span>
                    {/if}
                </td>
            </tr>
            <tr>
                <th>tips</th>
                <td>{$log.tips}</td>
            </tr>
            <tr>
                <th>method</th>
                <td>{$log.method}</td>
            </tr>
            <tr>
                <th>ip</th>
                <td>{$log.ip}</td>
            </tr>
            <tr>
                <th>time</th>
                <td>{:date('Y-m-d H:i:s', $log['time'])}</td>
            </tr>
            <tr>
                <th>data</th>
                <td>
                    <code style="word-break: break-word;width: 100%;white-space: pre-wrap;">{php}print_r(json_decode($log['data'], true));{/php}</code>
                </td>
            </tr>
        </tbody>
    </table>
</div>
{include common/footer@psrphp/admin}