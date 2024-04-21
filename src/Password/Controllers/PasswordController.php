<?php

namespace App\Password\Controllers;

use App\Auth\Traits\AuthJwt;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Password\Repository\PasswordRepository;
use Fig\Http\Message\StatusCodeInterface;

class PasswordController
{
    use AuthJwt;

    function __construct(
        private PasswordRepository $passwordReporitory = new PasswordRepository
    ){}

    function index(Request $request, Response $response) {
        
        $tokenUserAuth = $request->getHeader("auth-token");
        $idUserAuth = $this->validateToken($tokenUserAuth[0]);
                
        $pass = $this->passwordReporitory->getPasswords($idUserAuth->data->id);
        if(!$pass) return $response
                            ->withStatus(StatusCodeInterface::STATUS_NO_CONTENT)
                            ->withHeader("Content-Type", "appliction/json")
                            ->getBody()->write("Error al mostrar las contraseñas");

        $pass = json_encode($pass);
        $response->getBody()->write($pass);
        return $response->withHeader("Content-Type", "application/json")->withStatus(StatusCodeInterface::STATUS_OK);
    }
    
    function create (Request $request, Response $response) {
        
        $data = $request->getParsedBody();
        $data = intval($data["length"]);
        
        
        $passGen = $this->passwordReporitory->generatePassword($data);
        if(!$passGen) return $response->withStatus(400)->getBody()->write("password not generated");
    
        $passGen = json_encode($passGen);
        $response->getBody()->write($passGen);
    
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    }

    function store (Request $request, Response $response) 
    {
        $tokenUserAuth = $request->getHeader("auth-token");
        $idUserAuth = $this->validateToken($tokenUserAuth[0]);

        $data = $request->getParsedBody();
        $data["user_id"] = $idUserAuth->data->id;
        
        $passSaved = $this->passwordReporitory->savedPasswordGenerated($data);
        if(!$passSaved) return $response
                                    ->withStatus(StatusCodeInterface::STATUS_NO_CONTENT)
                                    ->withHeader("Content-Type", "appliction/json")
                                    ->getBody()->write("No se guardó la contreseña");

        $passSaved = json_encode($passSaved);

        $response->getBody()->write($passSaved);
        return $response->withHeader("Content-Type", "application/json")->withStatus(StatusCodeInterface::STATUS_OK);
    }

    function destroy(Request $request, Response $response, $args)
    {
        $tokenUserAuth = $request->getHeader("auth-token");
        $idUserAuth = $this->validateToken($tokenUserAuth[0]);

        $passDelete = $this->passwordReporitory->delete($args["id"], $idUserAuth->data->id);  
        
        if ($passDelete) {
            $response->getBody()->write("Pass Deleted");
            return $response->withHeader("Content-Type", "application/json")->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
        }
        $response->getBody()->write("no se pudo eliminar");
        return $response->withHeader("Content-Type", "application/json")->withStatus(StatusCodeInterface::STATUS_OK);


    }
}