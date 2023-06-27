<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Tool;

use App\Psrphp\Admin\Http\Common;
use Gregwar\Captcha\CaptchaBuilder;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use PsrPHP\Session\Session;

/**
 * 登录验证码，无需权限认证
 */
class Captcha extends Common
{
    public function get(
        Session $session,
        ResponseFactoryInterface $responseFactory,
        CaptchaBuilder $builder
    ): ResponseInterface {
        $response = $responseFactory->createResponse();
        $session->set('admin_captcha', strtolower($builder->getPhrase()));
        $response->getBody()->write($builder->build()->get());
        return $response->withHeader('Content-Type', 'image/jpeg');
    }
}
