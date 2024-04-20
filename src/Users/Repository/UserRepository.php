<?php

namespace App\Users\Repository;

use App\Config\Model;

class UserRepository
{
    function __construct(
        private Model $model = new Model
    ){}

    function verifyEmail(string $email) 
    {
        return $this->model->where("email", $email)->first();        
    }

    function register(array $data) 
    {
        $passHash = $this->model->passwordHash($data["password"]);
        $data["password"] = $passHash;
    
        $userSaved = $this->model->create($data);
        return $userSaved;
    }
}