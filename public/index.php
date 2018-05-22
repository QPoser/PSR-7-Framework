<?php

use Zend\Stratigility\MiddlewarePipe;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';


$aura = new \Aura\Router\RouterContainer();
$routes = $aura->getMap();

$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

$routes->get('home', '/', function(\Psr\Http\Message\ServerRequestInterface $request) {
    $name = $request->getQueryParams()['name'] ?? 'Guest';

    return new \Zend\Diactoros\Response\HtmlResponse('Hello, ' . $name . '!');
});

$routes->get('about.ab', '/about/{ab}', \App\Middleware\AboutAction::class);
$routes->get('about', '/about/', \App\Middleware\AboutAction::class);
$routes->get('blog', '/blog', \App\Middleware\BlogMiddleware::class);
$routes->get('blog.get', '/blog/{id}', function(\Psr\Http\Message\ServerRequestInterface $request) {
    $id = $request->getAttribute('id');

    if ($id > 2) {
        return new \Zend\Diactoros\Response\HtmlResponse('Undefined page', 404);
    }

    return new \Zend\Diactoros\Response\JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
})->tokens(['id' => '\d+']);
$routes->get('blog.test', '/blog/test', function() {
    return new \Zend\Diactoros\Response\HtmlResponse('Blog test.');
});
$router = new \Framework\Route\AuraRouterAdapter($aura);
$resolver = new \Framework\Route\MiddlewareResolver();


$pipeline = new MiddlewarePipe();

$pipeline->pipe(new \Framework\Middleware\StartMiddleware());
$pipeline->pipe(new \Framework\Middleware\RouteMiddleware($router));
$pipeline->pipe(new \Framework\Middleware\DispatchMiddleware($resolver));
//$pipeline->pipe(new \Framework\Middleware\CheckHandlerMiddleware($router, $resolver));
$pipeline->pipe(new \Framework\Middleware\NotFoundMiddleware());

$response = $pipeline->handle($request);

$emitter = new \Zend\Diactoros\Response\SapiEmitter();
$emitter->emit($response);


