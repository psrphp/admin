<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\PsrPHP;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Lazy;
use PsrPHP\Database\Db;
use PsrPHP\Framework\Config;
use PsrPHP\Framework\Framework;
use PsrPHP\Framework\Route;
use PsrPHP\Psr11\Container;
use PsrPHP\Psr15\RequestHandler;
use PsrPHP\Request\Request;
use PsrPHP\Router\Router;
use PsrPHP\Session\Session;
use PsrPHP\Template\Template;
use PsrPHP\Widget\Widget;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

class Hook
{
    public static function onStart(
        Route $route,
        RequestHandler $requestHandler,
        Container $container,
        Session $session
    ) {
        if (
            is_subclass_of($route->getHandler(), Common::class)
        ) {
            if (!$session->has('admin_auth')) {
                $requestHandler->prependMiddleware(new class() implements MiddlewareInterface
                {
                    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
                    {
                        return Framework::execute(function (
                            ResponseFactoryInterface $response_factory
                        ): ResponseInterface {
                            return $response_factory->createResponse(404);
                        });
                    }
                });
            }
        }

        $container->onInstance(Template::class, function (
            Container $container,
            Template $template
        ) {
            $template->assign([
                'db' => new Lazy($container, Db::class),
                'cache' => new Lazy($container, CacheInterface::class),
                'session' => new Lazy($container, Session::class),
                'logger' => new Lazy($container, LoggerInterface::class),
                'router' => new Lazy($container, Router::class),
                'config' => new Lazy($container, Config::class),
                'widget' => new Lazy($container, Widget::class),
                'request' => new Lazy($container, Request::class),
                'template' => $template,
                'container' => $container,
            ]);

            $template->extend('/\{widget\s*([\w\-_\.,@\/]*)\}/Ui', function ($matchs) {
                return '<?php echo $widget->get(\'' . $matchs[1] . '\') ?>';
            });
            $template->extend('/\{cache\s*(.*)\s*\}([\s\S]*)\{\/cache\}/Ui', function ($matchs) {
                $params = array_filter(explode(',', trim($matchs[1])));
                if (!isset($params[0])) {
                    $params[0] = 3600;
                }
                if (!isset($params[1])) {
                    $params[1] = 'tpl_extend_cache_' . md5($matchs[2]);
                }
                return '<?php echo call_user_func(function($args){
                            extract($args);
                            if (!$cache->has(\'' . $params[1] . '\')) {
                                $res = $template->renderFromString(base64_decode(\'' . base64_encode($matchs[2]) . '\'), $args, \'__' . $params[1] . '\');
                                $cache->set(\'' . $params[1] . '\', $res, ' . $params[0] . ');
                            }else{
                                $res = $cache->get(\'' . $params[1] . '\');
                            }
                            return $res;
                        }, get_defined_vars());?>';
            });
        });
    }
}
