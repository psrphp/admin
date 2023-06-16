<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Auth;

use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Log;
use App\Psrphp\Admin\Traits\RestfulTrait;
use Psr\Http\Message\ResponseInterface;
use PsrPHP\Request\Request;
use PsrPHP\Session\Session;
use PsrPHP\Template\Template;

/**
 * 登录后台，无需权限认证
 */
class Login
{
    use RestfulTrait;

    public function get(
        Template $template,
        Log $log
    ) {
        $log->record();
        return $template->renderFromFile('auth/login@psrphp/admin');
    }

    public function post(
        Request $request,
        Account $account,
        Session $session,
        Log $log
    ): ResponseInterface {
        $captcha = $_POST['captcha'];
        if (!$captcha || $captcha != $session->get('admin_captcha')) {
            return Response::error('验证码无效！');
        }
        $session->delete('admin_captcha');

        if (!$account->loginByName($request->post('account'), $request->post('password'))) {
            $log->record('登录失败[' . $request->post('account') . ']');
            return Response::error('认证失败！');
        } else {
            $log->record('登录成功');
            return Response::success('登录成功');
        }
    }
}
