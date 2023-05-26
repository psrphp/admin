<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http;

use App\Psrphp\Admin\Middleware\Auth;
use App\Psrphp\Admin\Traits\RestfulTrait;
use PsrPHP\Psr15\RequestHandler;

abstract class Common
{
    use RestfulTrait;

    public function __construct(
        RequestHandler $requestHandler,
        Auth $authMiddleware
    ) {
        $requestHandler->appendMiddleware($authMiddleware);
    }
}
