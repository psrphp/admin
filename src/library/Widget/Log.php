<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Widget;

use App\Psrphp\Admin\Http\Auth\Login;
use App\Psrphp\Admin\Model\WidgetInterface;
use PsrPHP\Database\Db;
use PsrPHP\Template\Template;

class Log implements WidgetInterface
{
    private $db;
    private $template;

    public function __construct(
        Db $db,
        Template $template,
    ) {
        $this->db = $db;
        $this->template = $template;
    }

    public function getTitle(): string
    {
        return '登录日志';
    }
    public function getContent(): string
    {
        $tpl = <<<'str'
<table>
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
str;
        return $this->template->renderFromString($tpl, [
            'logs' => $this->db->select('psrphp_admin_log', '*', [
                'node' => Login::class,
                'tips[!]' => '',
                'LIMIT' => 10,
                'ORDER' => [
                    'id' => 'DESC',
                ],
            ])
        ]);
    }
}
