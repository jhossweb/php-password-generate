<?php

namespace App\Users\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Config\Model;


class UserController extends Model
{
    function index(Request $request, Response $response) {
        
        $data = $request->getParsedBody();
        $this->create($data);

        $result = $this->all();
        $result = json_encode($result);

        $response->getBody()->write($result);
        return $response->withAddedHeader("Content-Type", "application/json");
    }
}