<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Log;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Database\Db;
use PsrPHP\Pagination\Pagination;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;

/**
 * 检索日志
 */
class Index extends Common
{
    public function get(
        Template $template,
        Request $request,
        Db $db,
        Pagination $pagination
    ) {

        $data = [];
        $where = [];
        if (strlen($request->get('q', ''))) {
            $where['data[~]'] = '%' . $request->get('q') . '%';
        }

        $total = $db->count('psrphp_admin_log', $where);
        $data['total'] = $total;

        $page = $request->get('page') ?: 1;
        $pagenum = $request->get('pagenum') ?: 20;
        $where['LIMIT'] = [($page - 1) * $pagenum, $pagenum];
        $where['ORDER'] = [
            'id' => 'DESC',
        ];
        $data['pages'] = $pagination->render($page, $total, $pagenum);
        $data['datas'] = $db->select('psrphp_admin_log', '*', $where);

        return $template->renderFromFile('log/index@psrphp/admin', $data);
    }
}
