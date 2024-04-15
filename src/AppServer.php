<?php

namespace App;

use App\Users\UserRouter;
use Slim\Factory\AppFactory;

class AppServer 
{
    public $app;

    function __construct()
    {
        $this->app = AppFactory::create();

        $this->router();
        $this->app->run();
    }

    function router () {
        (new UserRouter($this->app))->router;
    }
}