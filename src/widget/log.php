<?php

use App\Psrphp\Admin\Http\Auth\Login;

$logs = $db->select('psrphp_admin_log', '*', [
    'node' => Login::class,
    'tips[!]' => '',
    'LIMIT' => 10,
    'ORDER' => [
        'id' => 'DESC',
    ],
]);
?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>IP</th>
            <th>时间</th>
            <th>提示</th>
            <th>详情</th>
        </tr>
    </thead>
    <tbody>
        {foreach $logs as $v}
        <tr>
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