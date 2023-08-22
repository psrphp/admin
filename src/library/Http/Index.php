<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http;

use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
use PsrPHP\Template\Template;

/**
 * 后台主页
 */
class Index extends Common
{
    public function get(
        Auth $auth,
        Account $account,
        Template $template,
    ) {
        return $template->renderFromFile('index@psrphp/admin', [
            'auth' => $auth,
            'account' => $account,
            'sticks' => $account->getData($auth->getId(), 'psrphp_admin_menu', []),
        ]);
    }
}
