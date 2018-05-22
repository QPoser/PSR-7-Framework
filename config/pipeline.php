<?php

/** @var \Framework\Application $app */

$app->pipe(null, \Framework\Middleware\StartMiddleware::class);
$app->pipe('/cabinet', \App\Middleware\BasicAuthMiddleware::class);
$app->pipe(null, \Framework\Middleware\RouteMiddleware::class);
$app->pipe(null, \Framework\Middleware\DispatchMiddleware::class);
$app->pipe(null, \Framework\Middleware\NotFoundMiddleware::class);
