<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Model;

use PsrPHP\Framework\App;
use PsrPHP\Psr11\Container;

class WidgetProvider
{
    private $widgets = [];

    public function __construct(
        App $app,
        Container $container
    ) {
        $widgets = [];
        foreach ($app->all() as $vo) {
            foreach (glob($vo['dir'] . '/src/library/Widget/*.php') as $file) {
                $cls = 'App\\' . str_replace(['-', '/'], ['', '\\'], ucwords($vo['name'], '/-')) . '\\Widget\\' . pathinfo($file, PATHINFO_FILENAME);
                if (!$container->has($cls)) {
                    continue;
                }
                $obj = $container->get($cls);
                if (is_subclass_of($obj, WidgetInterface::class)) {
                    $widgets[] = $obj;
                }
            }
        }
        $this->widgets = $widgets;
    }

    public function all(): array
    {
        return $this->widgets;
    }

    final public static function create(string $title, string $content): WidgetInterface
    {
        return new class($title, $content) implements WidgetInterface
        {
            private $title;
            private $content;
            public function __construct(string $title, string $content)
            {
                $this->title = $title;
                $this->content = $content;
            }
            public function getTitle(): string
            {
                return $this->title;
            }
            public function getContent(): string
            {
                return $this->content;
            }
        };
    }
}
