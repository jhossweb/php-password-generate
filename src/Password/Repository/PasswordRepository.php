<?php

namespace App\Password\Repository;

use App\Config\Model;

class PasswordRepository extends Model
{
    protected $table = "passwords";
    protected $tableRelations = "users";

    protected $symbols = "!@#%^&*()_,./<>?;:[]{}\\|=+";

    function __construct()
    {
        $this->connect();
    }
    
    /** Consultas */
    function getPasswords ( int|string $id)
    {
        return $this->innerJoin($id)->get();
    }

    /* Insersiones */
    function generatePassword(int $length, bool $includeSymbols = false): string
    {
        $randomBytes = openssl_random_pseudo_bytes($length);
        $password = bin2hex($randomBytes);
        
        return $password;
    }

    function savedPasswordGenerated (array $data)
    {
        $passSaved = $this->create($data);
        return $passSaved;
    }

    function deletePass (int|string $idPass, int|string $idUserAuth)
    {
        $passToDelete = [
            "id"        => $idPass,
            "user_id"   => $idUserAuth
        ];
        
        return $this->delete($idPass, $idUserAuth);
    }
}