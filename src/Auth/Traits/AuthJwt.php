<?php

namespace App\Auth\Traits;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait AuthJwt
{
    private $key = "jhossweb";

    function generateToken (int|string $id, string $email)
    {
        $now = strtotime("now");
        $payload = [
            "data" => [
                "id" => $id,
                "email" => $email
            ],
            "exp" => strtotime("+90 minutes")
        ];

        $jwt = JWT::encode($payload, $this->key, "HS256");
        return $jwt;
    }

    function validateToken ($token) 
    {
        try {

            $validate = JWT::decode($token, new Key($this->key, "HS256"));
            return $validate;
            
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
			echo "Line: " . $e->getLine();
			return false;
        }
    }
}