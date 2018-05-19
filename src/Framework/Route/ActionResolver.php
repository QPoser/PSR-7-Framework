<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 19.05.2018
 * Time: 22:48
 */

namespace Framework\Route;


class ActionResolver
{

    public function resolve($handler): callable
    {
        return is_string($handler) ? new $handler() : $handler;
    }

}