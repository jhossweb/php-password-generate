<?php

namespace App\Password\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Password\Repository\PasswordRepository;

class PasswordController
{
    function __construct(
        private PasswordRepository $passwordReporitory = new PasswordRepository
    ){}

    function index(Request $request, Response $response) {

        $length = $request->getParsedBody();
        $length = intval($length["length"]);
        
        $passGen = $this->passwordReporitory->generatePassword($length);
        if(!$passGen) return $response->withStatus(400)->getBody()->write("password not generated");

        $passGen = json_encode($passGen);
        $response->getBody()->write($passGen);

        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    }
}