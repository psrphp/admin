<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Menu;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Model\Account;
use PsrPHP\Database\Db;
use PsrPHP\Template\Template;

/**
 * 功能地图
 */
class Index extends Common
{
    public function get(
        Template $template,
        Db $db,
        Account $account
    ) {
        return $template->renderFromFile('menu/index@psrphp/admin', [
            'menus' => json_decode($db->get('psrphp_admin_account_info', 'value', [
                'account_id' => $account->getAccountId(),
                'key' => 'psrphp_admin_menu',
            ]) ?: '[]', true),
        ]);
    }
}
