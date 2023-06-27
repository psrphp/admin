<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Auth;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Auth;
use App\Psrphp\Admin\Model\Log;
use Psr\Http\Message\ResponseInterface;
use PsrPHP\Request\Request;
use PsrPHP\Session\Session;
use PsrPHP\Template\Template;
use Throwable;

/**
 * 登录后台，无需权限认证
 */
class Login extends Common
{
    public function get(
        Template $template
    ) {
        Log::record();
        return $template->renderFromFile('auth/login@psrphp/admin');
    }

    public function post(
        Request $request,
        Auth $auth,
        Session $session
    ): ResponseInterface {
        $captcha = $_POST['captcha'];
        if (!$captcha || $captcha != $session->get('admin_captcha')) {
            Log::record('[' . $request->post('name') . ']登录失败，验证码无效~');
            return Response::error('验证码无效！');
        }
        $session->delete('admin_captcha');

        try {
            $auth->login($request->post('name'), $request->post('password'));
            return Response::success('登录成功');
        } catch (Throwable $th) {
            return Response::error($th->getMessage());
        }
    }
}
