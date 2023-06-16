<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Log;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;

/**
 * 日志详情
 */
class Detail extends Common
{
    public function get(
        Request $request,
        Db $db,
        Template $template
    ) {
        if (!$log = $db->get('psrphp_admin_log', '*', [
            'id' => $request->get('id'),
        ])) {
            return Response::error('日志不存在');
        }
        return $template->renderFromFile('log/detail@psrphp/admin', [
            'log' => $log,
        ]);
    }
}
