<?php

/** @var \Framework\Application $app */

$app->pipe(\Framework\Middleware\StartMiddleware::class);
$app->pipe('/cabinet', \App\Middleware\BasicAuthMiddleware::class);
$app->pipe(\Framework\Middleware\RouteMiddleware::class);
$app->pipe(\Framework\Middleware\DispatchMiddleware::class);
$app->pipe(\Framework\Middleware\NotFoundMiddleware::class);
