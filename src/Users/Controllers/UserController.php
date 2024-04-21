<?php

namespace App\Users\Controllers;

use App\Auth\Traits\AuthJwt;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Users\Repository\UserRepository;
use Fig\Http\Message\StatusCodeInterface;

class UserController 
{

    use AuthJwt;

    function __construct(
        private UserRepository $userRepository = new UserRepository
    ){}

    function index(Request $request, Response $response) {

        $tokenUserAuth = $request->getHeader("auth-token");
        $userAuth = $this->validateToken($tokenUserAuth[0]);
        echo $userAuth->data->id; // id del usuario Autenticado
        
        $result = $this->userRepository->all();
        $result = json_encode($result);

        $response->getBody()->write($result);
        return $response
                ->withAddedHeader("Content-Type", "application/json")
                ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}