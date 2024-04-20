<?php

namespace App\Config;

use PDO;
use PDOException;

class Model 
{
    protected $db_host 		= "mysqldb";
	protected $db_user 		= "root";
	protected $db_pass 		= "123456";
	protected $db_dbname 	= "phpslim";
	protected $db_port 		=   3306;

    protected $query;
    protected $connection;
    
	function connect() {
		try {

			$pdo = "mysql:host={$this->db_host};port={$this->db_port};dbname={$this->db_dbname}";
			$options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $this->connection = new PDO($pdo, $this->db_user, $this->db_pass, $options);

            return $this->connection;
		} catch(PDOException $e) {
			print_r("error de conexion: {$e->getMessage()}") . "\n";
            print_r("error en la linea: {$e->getLine()}") . "\n";
		}
	}

    function query ($sql, $data = [], $params = null) 
    {
        if($data){

            /* substr_count = cuenta cuando ? hay en la consulta */
            $numSignos = substr_count($sql, "?");

            $this->query = $this->connect()->prepare($sql);
            
            foreach($data as $key => $value) {
                $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $this->query->bindParam($key + 1, $data[$key], $type);
            }

            $this->query->bindParam(1, $data[0], PDO::PARAM_STR);
            $this->query->execute();

        } else {
            $this->query = $this->connection->prepare($sql);
            $this->query->execute();
        }

        return $this;
    }

    function first ()
    {
        return $this->query->fetch(PDO::FETCH_ASSOC);
    }

    function get()
    {
        return $this->query->fetchAll(PDO::FETCH_ASSOC);
    }

    
    /** Consultas  */
    function all ()
    {
        $sql = "SELECT * FROM users";
        return $this->query($sql)->get();
    }

    function findOne (int $id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        return $this->query($sql, [$id])->first();
    }

    function create(array $data) 
    {
        $colums = array_keys($data);
        $colums = implode(", ", $colums);

        $values = array_values($data);
        $sql = "INSERT INTO users ({$colums}) VALUES (" . str_repeat('?, ', count($values) -1) . "?)";
        
        $this->query($sql, $values);
        
        $user_id = $this->connection->lastInsertId();
        
        return $this->findOne($user_id);
    }

    function passwordHash (string $password) 
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    function where ($column, $operator, $value = null) 
    {
        if($value == null) {
            $value = $operator;
            $operator = "=";
        }

        $sql = "SELECT * FROM users WHERE {$column} {$operator} ?";
        $this->query($sql, [$value]);

        return $this;
    }
}