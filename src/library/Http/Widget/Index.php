<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Widget;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
use PsrPHP\Psr11\Container;
use PsrPHP\Template\Template;

class Index extends Common
{
    public function get(
        Auth $auth,
        Account $account,
        Template $template,
        Container $container,
    ) {
        $widgets = $account->getData($auth->getId(), 'widgets', []);
        foreach ($widgets as &$vo) {
            $vo = $container->get($vo);
        }
        return $template->renderFromFile('widget/index@psrphp/admin', [
            'auth' => $auth,
            'account' => $account,
            'widgets' => $widgets,
        ]);
    }
}
