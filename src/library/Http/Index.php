<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http;

use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
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
        Auth $auth,
        Account $account
    ) {
        switch ($request->get('t')) {
            case 'home':
                return $template->renderFromFile('home@psrphp/admin', [
                    'auth' => $auth,
                    'account' => $account,
                    'diys' => $account->getData($auth->getId(), 'admin_diy', []),
                ]);
                break;

            default:
                return $template->renderFromFile('index@psrphp/admin', [
                    'auth' => $auth,
                    'account' => $account,
                    'stick_menus' => $account->getData($auth->getId(), 'psrphp_admin_menu', []),
                ]);
                break;
        }
    }
}
