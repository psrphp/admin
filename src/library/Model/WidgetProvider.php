<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Model;

use PsrPHP\Psr14\Event;

class WidgetProvider
{
    private $widgets = [];

    public function __construct(
        Event $event
    ) {
        $event->dispatch($this);
    }

    public function add(Widget $widget)
    {
        $this->widgets[$widget::class] = $widget;
    }

    public function all(): array
    {
        return $this->widgets;
    }
}
