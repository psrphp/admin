<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Menu;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Model\Account;
use PsrPHP\Framework\Config;
use PsrPHP\Template\Template;

/**
 * 功能地图
 */
class Index extends Common
{
    public function get(
        Template $template,
        Config $config,
        Account $account
    ) {
        $menus = $config->get('menus.account_' . $account->getAccountId(), []);
        return $template->renderFromFile('menu/index@psrphp/admin', [
            'menus' => $menus,
        ]);
    }
}
