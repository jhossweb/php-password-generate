<?php

namespace App\Password;

use App\Config\BaseRouter;
use App\Password\Controllers\PasswordController;

class PasswordRouter extends BaseRouter
{
    function __construct($app){
        parent::__construct($app, PasswordController::class);
    }

    function routes()
    {
        $this->router->post("/generated-password", fn($request, $reponse) => $this->controller->index($request, $reponse));
    }
}