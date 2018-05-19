<?php
chdir(dirname(__DIR__));
require 'vendor/autoload.php';


$aura = new \Aura\Router\RouterContainer();
$routes = $aura->getMap();

$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

$routes->get('home', '/', function(\Psr\Http\Message\ServerRequestInterface $request) {
    $name = $request->getQueryParams()['name'] ?? 'Guest';

    return new \Zend\Diactoros\Response\HtmlResponse('Hello, ' . $name . '!');
});

$routes->get('about', '/about', function() {
    return new \Zend\Diactoros\Response\HtmlResponse('About.');
});

$routes->get('blog', '/blog', function() {
    return new \Zend\Diactoros\Response\HtmlResponse('Blog.');
});

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

$resolver = new \Framework\Route\ActionResolver();

try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $action = $resolver->resolve($result->getHandler());
    $response = $action($request);
} catch (RuntimeException $e) {
    $response = new \Zend\Diactoros\Response\HtmlResponse('Undefinded page', 404);
}

$response = $response->withHeader('X-Dev', 'Andrey');

$emitter = new \Zend\Diactoros\Response\SapiEmitter();
$emitter->emit($response);
