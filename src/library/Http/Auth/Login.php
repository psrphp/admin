<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Auth;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Auth;
use Psr\Http\Message\ResponseInterface;
use PsrPHP\Request\Request;
use PsrPHP\Router\Router;
use PsrPHP\Session\Session;
use PsrPHP\Template\Template;

/**
 * 登录后台，无需权限认证
 */
class Login extends Common
{
    public function get(
        Template $template
    ) {
        return $template->renderFromFile('auth/login@psrphp/admin');
    }

    public function post(
        Auth $auth,
        Router $router,
        Request $request,
        Session $session
    ): ResponseInterface {
        $captcha = $_POST['captcha'];
        if (!$captcha || $captcha != $session->get('admin_captcha')) {
            return Response::error('验证码无效！');
        }
        $session->delete('admin_captcha');

        if ($auth->login($request->post('name'), $request->post('password'))) {
            return Response::success('登录成功', null, $router->build('/psrphp/admin/index'));
        } else {
            return Response::error('账户或密码不正确');
        }
    }
}
