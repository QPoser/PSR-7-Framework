<?php

/** @var \Framework\Application $app */

use App\Middleware\AboutAction;
use App\Middleware\BlogAction;
use App\Middleware\CabinetAction;
use App\Middleware\HomeAction;

$app->get('home', '/', HomeAction::class);

$app->get('about.ab', '/about/{ab}', AboutAction::class);

$app->get('cabinet', '/cabinet', CabinetAction::class);

$app->get('about', '/about', AboutAction::class);

$app->get('blog', '/blog', BlogAction::class);

$app->get('blog.get', '/blog/{id}', BlogAction::class, ['tokens' => ['id' => '\d+']]);
