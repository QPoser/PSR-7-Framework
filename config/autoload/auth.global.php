<?php


return [
    'dependencies' => [
        'factories' => [
            \App\Middleware\BasicAuthMiddleware::class => function (\Psr\Container\ContainerInterface $container) {
                return new \App\Middleware\BasicAuthMiddleware($container->get('config')['auth']['users']);
            },
        ],
    ],

    'auth' => [
        'users' => [],
    ],
];