<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Model;

use Throwable;

class WidgetWarpper
{
    public function getTitle(WidgetInterface $widget): string
    {
        ob_start();
        try {
            $content = $widget->getTitle();
            ob_end_flush();
            return $content;
        } catch (Throwable $th) {
            ob_end_clean();
            ob_clean();
            return '错误:' . $th->getMessage();
        }
    }

    public function getContent(WidgetInterface $widget): string
    {
        ob_start();
        try {
            $content = $widget->getContent();
            ob_end_flush();
            return $content;
        } catch (Throwable $th) {
            ob_end_clean();
            ob_clean();
            return '<span style="color: red;">错误：' . $th->getMessage() . '</span><br><pre>' . $th->getTraceAsString() . '</pre>';
        }
    }
}
