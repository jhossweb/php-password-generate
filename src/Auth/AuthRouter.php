<?php

namespace App\Auth;

use App\Auth\Controllers\AuthController;
use App\Config\BaseRouter;

class AuthRouter extends BaseRouter
{
    function __construct($app)
    {
        parent::__construct($app, AuthController::class);
    }

    function routes()
    {
        $this->router->post(
            "/register",
            fn($request, $response) => $this->controller->register($request, $response)
        );
    }
}