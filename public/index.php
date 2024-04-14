<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$router = require_once __DIR__ . '/../routes/web.php';
$router($app);

$app->run();