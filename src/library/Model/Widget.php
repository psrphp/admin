<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Model;

use Throwable;

abstract class Widget
{
    abstract public function getTitle(): string;
    abstract public function getContent(): string;

    final public function title(): string
    {
        ob_start();
        try {
            $content = $this->getTitle();
            ob_end_flush();
            return $content;
        } catch (Throwable $th) {
            ob_end_clean();
            ob_clean();
            return '错误';
        }
    }

    final public function content(): string
    {
        ob_start();
        try {
            $content = $this->getContent();
            ob_end_flush();
            return $content;
        } catch (Throwable $th) {
            ob_end_clean();
            ob_clean();
            return '<span style="color: red;">错误：' . $th->getMessage() . '</span><br><pre>' . $th->getTraceAsString() . '</pre>';
        }
    }

    final public static function create(string $title, string $content): Widget
    {
        return new class($title, $content) extends Widget
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
