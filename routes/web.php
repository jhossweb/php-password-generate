<?php

use Slim\App;
use App\Controllers\UserController;

return function (App $router) {
    $router->get('/', UserController::class . ':index' );
};