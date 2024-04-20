<?php

namespace App;

use App\Auth\AuthRouter;
use App\Password\PasswordRouter;
use App\Users\UserRouter;
use Slim\Factory\AppFactory;

class AppServer 
{
    public $app;

    function __construct()
    {
        $this->app = AppFactory::create();

        $this->middlewares();
        $this->router();
        $this->app->run();
    }

    private function middlewares () {
        $this->app->addBodyParsingMiddleware();
    }

    function router () {
        (new UserRouter($this->app))->router;
        (new PasswordRouter($this->app))->router;
        (new AuthRouter($this->app))->router;
    }
}