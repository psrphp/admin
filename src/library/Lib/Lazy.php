<?php

namespace App\Psrphp\Admin\Lib;

use Psr\Container\ContainerInterface;

class Lazy
{
    private $class;
    private $container;

    public function __construct(ContainerInterface $container, string $class)
    {
        $this->class = $class;
        $this->container = $container;
    }

    public function __get($name)
    {
        return $this->getObj()->$name;
    }

    public function __set($name, $value)
    {
        return $this->getObj()->$name = $value;
    }

    public function __isset($name)
    {
        return isset($this->getObj()[$name]);
    }

    public function __call($name, $arguments)
    {
        return $this->getObj()->$name(...$arguments);
    }

    public function __invoke()
    {
        return $this->getObj();
    }

    private function getObj()
    {
        return $this->container->get($this->class);
    }
}
