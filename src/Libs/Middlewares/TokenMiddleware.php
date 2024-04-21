<?php

namespace App\Libs\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Slim\Psr7\Response;

use Fig\Http\Message\StatusCodeInterface;

class TokenMiddleware
{
    private $key = "jhossweb";

    function __invoke(Request $request, RequestHandler $handler)
    {
        $token = $request->getHeaderLine("auth-token");
        if (empty($token)) {
            return new Response(StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        try {

            $decoded = JWT::decode($token, new Key($this->key, "HS256"));
            $request  = $request->withAttribute("id", $decoded->data->id);
            $request  = $request->withAttribute("email", $decoded->data->email);
            
        } catch (\Exception $e) {
            return new Response(StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        $response = $handler->handle($request);
        return $response;
    }
}