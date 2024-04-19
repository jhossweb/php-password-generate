<?php

namespace App\Password\Interfaces;

interface IPasswordGenerator
{
    public function generatePassword(int $length, bool $includeSymbols = false): string;
}