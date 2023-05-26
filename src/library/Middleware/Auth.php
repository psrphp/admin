<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Middleware;

use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Account;
use PsrPHP\Router\Router;
use PsrPHP\Framework\Framework;
use PsrPHP\Framework\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Auth implements MiddlewareInterface
{

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        return Framework::execute(function (
            Account $account,
            Router $router,
            Route $route
        ) use ($request, $handler): ResponseInterface {
            if (!$account->isLogin()) {
                return Response::error('请登录', $router->build('/psrphp/admin/auth/login'));
            }
            if (!$account->checkAuth($route->getHandler())) {
                return Response::error('无权限');
            }
            return $handler->handle($request);
        });
    }
}
