<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http;

use App\Psrphp\Admin\Lib\Response;
use App\Psrphp\Admin\Middleware\AuthMiddleware;
use App\Psrphp\Admin\Model\Log;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PsrPHP\Framework\Framework;
use PsrPHP\Framework\Handler;

abstract class Common implements RequestHandlerInterface
{
    public function __construct(
        Handler $handler,
        AuthMiddleware $authMiddleware
    ) {
        Log::record();
        $handler->pushMiddleware($authMiddleware);
    }

    public function handle(
        ServerRequestInterface $request
    ): ResponseInterface {
        $method = strtolower($request->getMethod());
        if (in_array($method, ['get', 'put', 'post', 'delete', 'head', 'patch', 'options']) && is_callable([$this, $method])) {
            $resp = Framework::execute([$this, $method]);
            if (is_scalar($resp) || (is_object($resp) && method_exists($resp, '__toString'))) {
                return Response::html((string)$resp);
            }
            return $resp;
        } else {
            return Framework::execute(function (
                ResponseFactoryInterface $response_factory
            ): ResponseInterface {
                return $response_factory->createResponse(405);
            });
        }
    }
}
