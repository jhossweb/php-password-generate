<?php

namespace App\Config;

use Slim\App;

class BaseRouter
{
    public $router;
    public $controller;

    function __construct(App $router, $controller)
    {
        $this->router = $router;
        $this->controller = new $controller;

        $this->routes();
    }

    function routes () {}
}