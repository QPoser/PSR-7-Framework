<?php


$config = require __DIR__ . '/config.php';

$container = new \Zend\ServiceManager\ServiceManager($config['dependencies']);

$container->setService('config', $config);

return $container;