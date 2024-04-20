<?php

namespace App\Auth\Controllers;

use App\Users\Repository\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    function __construct(
        private UserRepository $userRepository = new UserRepository
    ) {}

    function register(Request $request, Response $response) 
    {
        $data = $request->getParsedBody();
        
        $verifyEmail = $this->userRepository->verifyEmail($data["email"]);
        if($verifyEmail){
            $response->getBody()->write("Email en uso");            
            return $response->withHeader("Content-Type", "application/json")->withStatus(400);
        } 
        
        $userSaved = $this->userRepository->register($data);
        $userSaved = json_encode($userSaved);

        $response->getBody()->write($userSaved);
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    }
}