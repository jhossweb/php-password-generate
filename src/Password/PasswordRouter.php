<?php

namespace App\Password;

use App\Config\BaseRouter;
use App\Libs\Middlewares\TokenMiddleware;
use App\Password\Controllers\PasswordController;

class PasswordRouter extends BaseRouter
{
    function __construct($app){
        parent::__construct($app, PasswordController::class);
    }

    function routes()
    {
        $this->router->get(
            "/my-password", 
            fn($request, $reponse) => $this->controller->index($request, $reponse))->add(new TokenMiddleware);

        $this->router->post(
            "/generated-password", 
            fn($request, $reponse) => $this->controller->create($request, $reponse))->add(new TokenMiddleware);
        
            $this->router->post(
                "/saved-password", 
                fn($request, $reponse) => $this->controller->store($request, $reponse))->add(new TokenMiddleware);

            $this->router->delete(
                "/destroy-password/{id}", 
                fn($request, $reponse, $args) => $this->controller->destroy($request, $reponse, $args))->add(new TokenMiddleware);
    }
}