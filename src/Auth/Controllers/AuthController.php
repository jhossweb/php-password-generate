<?php

namespace App\Auth\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\Users\Repository\UserRepository;
use App\Auth\Traits\AuthJwt;

class AuthController
{
    use AuthJwt;

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

    function signin (Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $verifyEmail = $this->userRepository->verifyEmail($data["email"]);
        if(!$verifyEmail) {
            $response->getBody()->write("Email en uso");            
            return $response->withHeader("Content-Type", "application/json")->withStatus(400);
        }

        $verifyPass = $this->userRepository->passwordVerify($data["password"], $verifyEmail["password"]);
        if(!$verifyPass) {
            $response->getBody()->write("Email en uso");            
            return $response->withHeader("Content-Type", "application/json")->withStatus(400);
        }

        $token = $this->generateToken($verifyEmail["id"], $verifyEmail["email"]);
        
        $response->getBody()->write($token);            
        return $response
                ->withHeader("Content-Type", "application/json")
                ->withHeader("auth-token", $token)
                ->withStatus(200);
    }
}