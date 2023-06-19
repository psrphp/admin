<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Http\Widget;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Framework\Widget;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;

/**
 * 预览挂件
 */
class Preview extends Common
{
    public function get(
        Request $request,
        Widget $widget,
        Template $template
    ) {
        return $template->renderFromFile('widget/preview@psrphp/admin', [
            'code' => $widget->get($request->get('name')),
        ]);
    }
}
