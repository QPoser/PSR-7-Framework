<?php


use Framework\Application;
use Framework\Route\Router;

return [
    'dependencies' => [
        'abstract_factories' => [
            \Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            \Framework\Application::class => function (\Psr\Container\ContainerInterface $container) {
                return new Application(
                    $container->get(\Framework\Route\MiddlewareResolver::class),
                    $container->get(Router::class)
                );
            },
            Router::class => function () {
                return new \Framework\Route\AuraRouterAdapter(new \Aura\Router\RouterContainer());
            },
            \Framework\Route\MiddlewareResolver::class => function (\Psr\Container\ContainerInterface $container) {
                return new \Framework\Route\MiddlewareResolver($container);
            },
            \Framework\Template\TemplateRenderer::class => function (\Psr\Container\ContainerInterface $container) {
                return new \Framework\Template\PhpRenderer('templates', $container->get(Router::class));
            },
        ]
    ],

    'debug' => false,
];