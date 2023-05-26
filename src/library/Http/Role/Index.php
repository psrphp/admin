<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Role;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Database\Db;
use PsrPHP\Template\Template;

/**
 * 查看角色列表
 */
class Index extends Common
{
    public function get(
        Db $db,
        Template $template
    ) {
        $data = [];
        $data['datas'] = $db->select('psrphp_admin_role', '*', [
            'ORDER' => [
                'id' => 'ASC',
            ],
        ]);
        return $template->renderFromFile('role/index@psrphp/admin', $data);
    }
}
