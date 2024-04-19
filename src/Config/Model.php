<?php

namespace App\Config;

use App\Config\Conexion;
use PDO;

class Model 
{
    function __construct(private Conexion $conexion = new Conexion) {}

    function create(array $data) {
        $colums = array_keys($data);
        $colums = implode(", ", $colums);

        $values = array_values($data);
        $sql = "INSERT INTO users (name) VALUES (:name)";
        
        $query = $this->conexion->connect()->prepare($sql);
        $query->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $query->execute();

        return true;
    }

    function all() {
        $sql = "SELECT * FROM users";
        $query = $this->conexion->connect()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
}