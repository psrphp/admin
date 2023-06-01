<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http;

use App\Psrphp\Admin\Model\Account;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;

/**
 * 后台主页
 */
class Index extends Common
{
    public function get(
        Template $template,
        Request $request,
        Db $db,
        Account $account
    ) {
        switch ($request->get('t')) {
            case 'home':
                return $template->renderFromFile('home@psrphp/admin', [
                    'account' => $account,
                ]);
                break;

            default:
                return $template->renderFromFile('index@psrphp/admin', [
                    'account' => $account,
                    'menus' => json_decode($db->get('psrphp_admin_account_info', 'value', [
                        'account_id' => $account->getAccountId(),
                        'key' => 'psrphp_admin_menu',
                    ]) ?: '[]', true),
                ]);
                break;
        }
    }
}
