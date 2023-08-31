<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Widget;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Model\WidgetProvider;
use App\Psrphp\Admin\Model\WidgetWarpper;
use PsrPHP\Framework\App;
use PsrPHP\Template\Template;

class Diy extends Common
{
    public function get(
        Template $template,
        WidgetProvider $widgetProvider,
        WidgetWarpper $widgetWarpper
    ) {
        return $template->renderFromFile('widget/diy@psrphp/admin', [
            'widgetProvider' => $widgetProvider,
            'widgetWarpper' => $widgetWarpper,
        ]);
    }
}
