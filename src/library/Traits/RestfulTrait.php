<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Traits;

use PsrPHP\Framework\Framework;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

trait RestfulTrait
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseFactoryInterface $response_factory
    ) {
        $method = strtolower($request->getMethod());
        if (in_array($method, ['get', 'put', 'post', 'delete', 'head', 'patch', 'options']) && is_callable([$this, $method])) {
            return Framework::execute([$this, $method]);
        } else {
            return $response_factory->createResponse(405);
        }
    }
}
