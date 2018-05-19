<?php

require '../vendor/autoload.php';

echo 'Hello ' . ($_GET['name'] ?: 'guest') . '!';

$request = new \Framework\Http\Request();
