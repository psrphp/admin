<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Department;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Database\Db;
use PsrPHP\Template\Template;

/**
 * 查看组织结构
 */
class Index extends Common
{
    public function get(
        Db $db,
        Template $template
    ) {
        $data = [];
        $data['departments'] = $db->select('psrphp_admin_department', '*');
        return $template->renderFromFile('department/index@psrphp/admin', $data);
    }
}
