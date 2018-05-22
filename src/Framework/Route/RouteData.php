<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 22.05.2018
 * Time: 22:09
 */

namespace Framework\Route;


class RouteData
{

    public $name, $path, $handler, $methods, $options;

    public function __construct($name, $path, $handler, array $methods, array $options)
    {
        $this->name = $name;
        $this->path = $path;
        $this->handler = $handler;
        $this->methods = array_map('mb_strtoupper', $methods);
        $this->options = $options;
    }

}