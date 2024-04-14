<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController 
{
    function index(Request $request, Response $response) {
        $response->getBody()->write("hola mundo");
        return $response;
    }
}