<?php

namespace App\Users\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Config\Conexion;

class UserController 
{
    function index(Request $request, Response $response) {
        $cnx = new Conexion;
        $sql = "SELECT NOW()";
        $result = $cnx->connect()->prepare("SELECT NOW()");
        $result->execute();
        var_dump($result);
        
        $response->getBody()->write("hello");
        return $response;
    }
}