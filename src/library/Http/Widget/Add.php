<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Widget;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
use PsrPHP\Request\Request;
use PsrPHP\Router\Router;

class Add extends Common
{
    public function post(
        Auth $auth,
        Router $router,
        Account $account,
        Request $request,
    ) {
        $widgets = $account->getData($auth->getId(), 'widgets', []);
        $widgets[] = $request->post('name');
        $account->setData($auth->getId(), 'widgets', $widgets);
        return Response::redirect($router->build('/psrphp/admin/widget/index', ['diy' => 1]));
    }
}
