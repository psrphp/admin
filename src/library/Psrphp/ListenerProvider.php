<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Psrphp;

use App\Psrphp\Admin\Http\Account\Index as AccountIndex;
use App\Psrphp\Admin\Http\Cache\Clear;
use App\Psrphp\Admin\Http\Department\Index as DepartmentIndex;
use App\Psrphp\Admin\Http\Plugin\Index as PluginIndex;
use App\Psrphp\Admin\Http\Theme\Index as ThemeIndex;
use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Middleware\AuthMiddleware;
use App\Psrphp\Admin\Model\MenuProvider;
use App\Psrphp\Admin\Model\WidgetProvider;
use App\Psrphp\Admin\Widget\System;
use Psr\EventDispatcher\ListenerProviderInterface;
use PsrPHP\Database\Db;
use PsrPHP\Framework\Config;
use PsrPHP\Framework\Framework;
use PsrPHP\Framework\Handler;
use PsrPHP\Psr11\Container;
use PsrPHP\Request\Request;
use PsrPHP\Router\Router;
use PsrPHP\Session\Session;
use PsrPHP\Template\Template;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

class ListenerProvider implements ListenerProviderInterface
{
    public function getListenersForEvent(object $event): iterable
    {
        if (is_a($event, Common::class)) {
            yield function () use ($event) {
                Framework::execute(function (
                    Container $container
                ) {
                    $container->set(Template::class, function (
                        Db $db,
                        CacheInterface $cache,
                        Session $session,
                        LoggerInterface $logger,
                        Router $router,
                        Config $config,
                        Request $request,
                        Template $template,
                        Container $container,
                    ) {
                        $template->assign([
                            'db' => $db,
                            'cache' => $cache,
                            'session' => $session,
                            'logger' => $logger,
                            'router' => $router,
                            'config' => $config,
                            'request' => $request,
                            'template' => $template,
                            'container' => $container,
                        ]);
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
                        return $template;
                    });
                }, [
                    Common::class => $event,
                ]);
            };
        }

        if (is_a($event, Common::class)) {
            yield function () use ($event) {
                Framework::execute(function (
                    Handler $handler,
                    Session $session,
                ) {
                    if ($session->has('admin_auth')) {
                        return;
                    }
                    $handler->unShiftMiddleware(new class() implements MiddlewareInterface
                    {
                        public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
                        {
                            return Framework::execute(function (
                                ResponseFactoryInterface $factory
                            ): ResponseInterface {
                                return $factory->createResponse(404);
                            });
                        }
                    });
                }, [
                    Common::class => $event,
                ]);
            };
        }

        if (is_a($event, Common::class)) {
            yield function () use ($event) {
                Framework::execute(function (
                    Handler $handler,
                    AuthMiddleware $authMiddleware
                ) {
                    $handler->pushMiddleware($authMiddleware);
                }, [
                    Common::class => $event,
                ]);
            };
        }

        if (is_a($event, WidgetProvider::class)) {
            yield function () use ($event) {
                Framework::execute(function (
                    WidgetProvider $widgetProvider,
                    System $system,
                ) {
                    $widgetProvider->add($system);
                }, [
                    WidgetProvider::class => $event,
                ]);
            };
        }

        if (is_a($event, MenuProvider::class)) {
            yield function () use ($event) {
                Framework::execute(function (
                    MenuProvider $provider
                ) {
                    $provider->add('组织结构', DepartmentIndex::class);
                    $provider->add('账户管理', AccountIndex::class);
                    $provider->add('插件管理', PluginIndex::class);
                    $provider->add('主题管理', ThemeIndex::class);
                    $provider->add('清理缓存', Clear::class);
                }, [
                    MenuProvider::class => $event,
                ]);
            };
        }
    }
}
