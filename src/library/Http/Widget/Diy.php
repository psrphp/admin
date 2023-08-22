<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Widget;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Model\WidgetProvider;
use PsrPHP\Template\Template;

class Diy extends Common
{
    public function get(
        Template $template,
        WidgetProvider $widgetProvider,
    ) {
        return $template->renderFromFile('widget/diy@psrphp/admin', [
            'widgetProvider' => $widgetProvider,
        ]);
    }
}
