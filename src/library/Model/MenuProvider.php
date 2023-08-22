<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Model;

use PsrPHP\Psr14\Event;

class MenuProvider
{
    private $menus = [];

    public function __construct(
        Event $event
    ) {
        $event->dispatch($this);
    }

    public function add(string $title, string $node, array $query = [])
    {
        $this->menus[] = [
            'title' => $title,
            'node' => $node,
            'query' => $query,
        ];
    }

    public function all(): array
    {
        return $this->menus;
    }
}
