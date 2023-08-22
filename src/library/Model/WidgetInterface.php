<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Model;

interface WidgetInterface
{
    public function getTitle(): string;
    public function getContent(): string;
}
