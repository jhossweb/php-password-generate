<?php

namespace App\Users;

use App\Config\BaseRouter;
use App\Libs\Middlewares\TokenMiddleware;
use App\Users\Controllers\UserController;

class UserRouter extends BaseRouter
{
    function __construct($app)
    {
        parent::__construct($app, UserController::class);
    }

    function routes()
    {
        $this->router->get("/", fn($request, $response) => $this->controller->index($request, $response))->add(new TokenMiddleware);
    }
}