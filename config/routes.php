<?php

$app->get('home', '/', function () {
    return new \Zend\Diactoros\Response\HtmlResponse('Home page.');
});

$app->get('about.ab', '/about/{ab}', \App\Middleware\AboutAction::class);

$app->get('cabinet', '/cabinet', function(\Psr\Http\Message\ServerRequestInterface $request) {
    return new \Zend\Diactoros\Response\HtmlResponse('Hello, you logined!');
});

$app->get('about', '/about/', \App\Middleware\AboutAction::class);

$app->get('blog', '/blog', \App\Middleware\BlogMiddleware::class);

$app->get('blog.get', '/blog/{id}', function(\Psr\Http\Message\ServerRequestInterface $request) {
    $id = $request->getAttribute('id');

    if ($id > 2) {
        return new \Zend\Diactoros\Response\HtmlResponse('Undefined page', 404);
    }

    return new \Zend\Diactoros\Response\JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
}, ['tokens' => ['id' => '\d+']]);

$app->get('blog.test', '/blog/test', function() {
    return new \Zend\Diactoros\Response\HtmlResponse('Blog test.');
});