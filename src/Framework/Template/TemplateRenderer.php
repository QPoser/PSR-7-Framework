<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 23.05.2018
 * Time: 21:07
 */

namespace Framework\Template;


interface TemplateRenderer
{
    public function render($name, array $params = []): string;
}