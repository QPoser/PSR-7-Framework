<?php


use Aura\Router\RouterContainer;
use Framework\Application;
use Framework\Middleware\ErrorHandlerMiddleware;
use Framework\Route\AuraRouterAdapter;
use Framework\Route\MiddlewareResolver;
use Framework\Route\Router;
use Framework\Template\Php\Extension\RouteExtension;
use Framework\Template\PhpRenderer;
use Framework\Template\TemplateRenderer;
use Framework\Template\TwigRenderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'dependencies' => [
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            Application::class => function (ContainerInterface $container) {
                return new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(Router::class)
                );
            },
            Router::class => function () {
                return new AuraRouterAdapter(new RouterContainer());
            },
            MiddlewareResolver::class => function (ContainerInterface $container) {
                return new MiddlewareResolver($container);
            },
	        Environment::class => function (ContainerInterface $container) {

				$templateDir = 'templates';
				$cacheDir = 'var/cache/twig';
				$debug = $container->get('config')['debug'];

				$loader = new \Twig\Loader\FilesystemLoader();
				$loader->addPath($templateDir);

				$environment = new Environment($loader, [
					'cache' => $debug ? false : $cacheDir,
					'debug' => $debug,
					'strict_variables' => $debug,
					'auto_reload' => $debug,
				]);

				if ($debug) {
					$environment->addExtension(new \Twig\Extension\DebugExtension());
				}

				$environment->addExtension($container->get(RouteExtension::class));

				return $environment;
	        },
	        RouteExtension::class => function (ContainerInterface $container) {
				return new RouteExtension($container->get(Router::class));
	        },
            TemplateRenderer::class => function (ContainerInterface $container) {
				return new TwigRenderer($container->get(Environment::class));
                //return new PhpRenderer('templates', $container->get(Router::class));
            },
	        ErrorHandlerMiddleware::class => function (ContainerInterface $container) {
				return new ErrorHandlerMiddleware(
						$container->get('config')['debug'],
						$container->get(TemplateRenderer::class)
				);
	        },
        ]
    ],

    'debug' => false,
];