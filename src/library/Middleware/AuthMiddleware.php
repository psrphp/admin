<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Middleware;

use App\Psrphp\Admin\Http\Auth\Login;
use App\Psrphp\Admin\Http\Tool\Captcha;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
use PsrPHP\Router\Router;
use PsrPHP\Framework\Framework;
use PsrPHP\Framework\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        return Framework::execute(function (
            Auth $auth,
            Account $account,
            Router $router,
            Route $route
        ) use ($request, $handler): ResponseInterface {
            if (!in_array($route->getHandler(), [Captcha::class, Login::class])) {
                if (!$auth->isLogin()) {
                    if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
                        return Response::error('请登录', $router->build('/psrphp/admin/auth/login'));
                    } else {
                        return Response::redirect($router->build('/psrphp/admin/auth/login'));
                    }
                }
                if (!$account->checkAuth($auth->getId(), $route->getHandler())) {
                    return Response::error('无权限');
                }
            }
            return $handler->handle($request);
        });
    }
}
