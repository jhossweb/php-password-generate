<?php

namespace App\Users\Repository;

use App\Config\Model;

class UserRepository extends Model
{   
    protected $table = "users";

    function __construct()
    {
        return $this->connect();
    }

    function verifyEmail(string $email) 
    {
        return $this->where("email", $email)->first();        
    }

    function register(array $data) 
    {
        $passHash = $this->passwordHash($data["password"]);
        $data["password"] = $passHash;
    
        $userSaved = $this->create($data);
        return $userSaved;
    }

    function passwordHash (string $password) 
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    function passwordVerify(string $pass, string $passHash)
    {
        return password_verify($pass, $passHash);
    }
}