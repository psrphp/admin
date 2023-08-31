<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Widget;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Admin\Model\Auth;
use App\Psrphp\Admin\Model\WidgetInterface;
use App\Psrphp\Admin\Model\WidgetProvider;
use App\Psrphp\Admin\Model\WidgetWarpper;
use PsrPHP\Psr11\Container;
use PsrPHP\Template\Template;

class Index extends Common
{
    public function get(
        Auth $auth,
        Account $account,
        Template $template,
        Container $container,
        WidgetWarpper $widgetWarpper
    ) {
        $widgets = $account->getData($auth->getId(), 'widgets', []);
        foreach ($widgets as &$vo) {
            if ($container->has($vo)) {
                $obj = $container->get($vo);
                if (!is_a($obj, WidgetInterface::class)) {
                    $vo = WidgetProvider::create('错误', '<span style="color: red;">挂件：' . $vo . '非挂件实例，请移除~</span>');
                } else {
                    $vo = $obj;
                }
            } else {
                $vo = WidgetProvider::create('错误', '<span style="color: red;">挂件：' . $vo . '不存在，请移除~</span>');
            }
        }
        return $template->renderFromFile('widget/index@psrphp/admin', [
            'auth' => $auth,
            'account' => $account,
            'widgets' => $widgets,
            'widgetWarpper' => $widgetWarpper,
        ]);
    }
}
