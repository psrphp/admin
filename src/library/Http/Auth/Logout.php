<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Auth;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Auth;
use Psr\Http\Message\ResponseInterface;
use PsrPHP\Router\Router;
use Throwable;

/**
 * 退出后台
 */
class Logout extends Common
{
    public function get(
        Auth $auth,
        Router $router
    ): ResponseInterface {
        try {
            $auth->logout();
            return Response::redirect($router->build('/psrphp/admin/index'));
        } catch (Throwable $th) {
            return Response::error($th->getMessage());
        }
    }
}
