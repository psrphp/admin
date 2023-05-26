<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http;

use App\Psrphp\Admin\Model\Account;
use PsrPHP\Framework\Config;
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
        Config $config,
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
                    'menus' => $config->get('menus.account_' . $account->getAccountId(), []),
                ]);
                break;
        }
    }
}
