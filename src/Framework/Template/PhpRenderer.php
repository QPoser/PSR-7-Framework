<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 23.05.2018
 * Time: 21:06
 */

namespace Framework\Template;


use Framework\Route\Router;

class PhpRenderer implements TemplateRenderer
{

    private $path, $extend, $blocks = [], $blockNames, $router;

    public function __construct($path, Router $router)
    {
        $this->path = $path;
        $this->router = $router;
        $this->blockNames = new \SplStack();
    }

    public function render($name, array $params = []): string
    {
        $templateFile = $this->path . '/' . $name . '.php';
        ob_start();
        extract($params, EXTR_OVERWRITE);
        $this->extend = null;
        require $templateFile;
        $content = ob_get_clean();
        if (!$this->extend) {
            return $content;
        }
        return $this->render($this->extend);
    }

    public function extend($view): void
    {
        $this->extend = $view;
    }

    public function block($name, $content)
    {
        if ($this->hasBlock($name)) {
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function ensureBlock($name): bool
    {
        if ($this->hasBlock($name)) {
            return false;
        }
        $this->beginBlock($name);
        true;
    }

    public function beginBlock($name): void
    {
        $this->blockNames->push($name);
        ob_start();
    }

    public function endBlock(): void
    {
        $content = ob_get_clean();
        $name = $this->blockNames->pop();
        if ($this->hasBlock($name)) {
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function renderBlock($name): string
    {
        $block = $this->blocks[$name] ?? null;

        if ($block instanceof \Closure) {
            return $block();
        }

        return $block ?? '';
    }

    private function hasBlock($name): bool
    {
        return array_key_exists($name, $this->blocks);
    }

    public function encode($string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE);
    }

    public function path($name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }
}