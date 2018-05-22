<?php

use Framework\Http\Response;
use Zend\Stratigility\MiddlewarePipe;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';
$app = $container->get(\Framework\Application::class);

require 'config/pipeline.php';
require 'config/routes.php';

$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();
$response = $app->run($request);

$emitter = new \Zend\Diactoros\Response\SapiEmitter();
$emitter->emit($response);




