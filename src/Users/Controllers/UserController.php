<?php

namespace App\Users\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Users\Repository\UserRepository;
use Fig\Http\Message\StatusCodeInterface;

class UserController 
{
    function __construct(
        private UserRepository $userRepository = new UserRepository
    ){}

    function index(Request $request, Response $response) {

        $result = $this->userRepository->all();
        $result = json_encode($result);

        $response->getBody()->write($result);
        return $response
                ->withAddedHeader("Content-Type", "application/json")
                ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}