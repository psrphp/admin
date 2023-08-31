<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Widget;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
use PsrPHP\Request\Request;
use PsrPHP\Router\Router;

class Remove extends Common
{
    public function post(
        Auth $auth,
        Router $router,
        Request $request,
        Account $account,
    ) {
        $widgets = $account->getData($auth->getId(), 'widgets', []);
        $index = $request->post('index');
        unset($widgets[$index]);
        $account->setData($auth->getId(), 'widgets', array_values($widgets));
        return Response::redirect($router->build('/psrphp/admin/widget/index', ['diy' => 1]));
    }
}
