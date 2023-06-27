<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http;

use App\Psrphp\Admin\Middleware\AuthMiddleware;
use App\Psrphp\Admin\Model\Log;
use App\Psrphp\Admin\Traits\RestfulTrait;
use PsrPHP\Psr15\RequestHandler;

abstract class Common
{
    use RestfulTrait;

    public function __construct(
        RequestHandler $requestHandler,
        AuthMiddleware $authMiddleware
    ) {
        Log::record();
        $requestHandler->appendMiddleware($authMiddleware);
    }
}
