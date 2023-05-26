<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Auth;

use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Traits\ResponseTrait;
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
    use ResponseTrait;

    public function get(
        Template $template
    ) {
        return $template->renderFromFile('auth/login@psrphp/admin');
    }

    public function post(
        Request $request,
        Account $account,
        Session $session
    ): ResponseInterface {
        $captcha = $_POST['captcha'];
        if (!$captcha || $captcha != $session->get('admin_captcha')) {
            return $this->error('验证码无效！');
        }
        $session->delete('admin_captcha');

        if (!$account->loginByName($request->post('account'), $request->post('password'))) {
            return $this->error('认证失败！');
        }

        return $this->success('登录成功');
    }
}
