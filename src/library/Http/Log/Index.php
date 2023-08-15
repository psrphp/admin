<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Log;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Model\Account;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;

/**
 * 检索日志
 */
class Index extends Common
{
    public function get(
        Db $db,
        Request $request,
        Account $account,
        Template $template,
    ) {

        $data = [];
        $where = [];
        if (strlen($request->get('q', ''))) {
            $where['data[~]'] = '%' . $request->get('q') . '%';
        }

        $total = $db->count('psrphp_admin_log', $where);
        $data['total'] = $total;

        $page = $request->get('page') ?: 1;
        $size = $request->get('size') ?: 20;
        $where['LIMIT'] = [($page - 1) * $size, $size];
        $where['ORDER'] = [
            'id' => 'DESC',
        ];
        $data['maxpage'] = ceil($total / $size) ?: 1;
        $data['datas'] = $db->select('psrphp_admin_log', '*', $where);
        $data['account'] = $account;

        return $template->renderFromFile('log/index@psrphp/admin', $data);
    }
}
