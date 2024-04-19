<?php

namespace App\Password\Repository;

use App\Password\Interfaces\IPasswordGenerator;

class PasswordRepository implements IPasswordGenerator
{
    protected $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    protected $symbols = "!@#%^&*()_,./<>?;:[]{}\\|=+";
    protected $numbers = "0123456789";

    function generatePassword(int $length, bool $includeSymbols = false): string
    {
        $randomBytes = openssl_random_pseudo_bytes($length);
        $password = bin2hex($randomBytes);
        
        return $password;
    }
}