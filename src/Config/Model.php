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

    /** Se agrega esta propiredad para que el editor no marque error */
    protected $table;
        
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

            $this->query = $this->connection->prepare($sql);
            
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
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql)->get();
    }

    function findOne (int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id])->first();
    }

    function create(array $data) 
    {
        $colums = array_keys($data);
        $colums = implode(", ", $colums);

        $values = array_values($data);
        $sql = "INSERT INTO {$this->table} ({$colums}) VALUES (" . str_repeat('?, ', count($values) -1) . "?)";
        
        $this->query($sql, $values);
        
        $user_id = $this->connection->lastInsertId();
        
        return $this->findOne($user_id);
    }

   

    function where ($column, $operator, $value = null) 
    {
        if($value == null) {
            $value = $operator;
            $operator = "=";
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$column} {$operator} ?";
        $this->query($sql, [$value]);

        return $this;
    }

    function delete (int|string $id, int|string $idUserAuth)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ? AND user_id = ?";
        $this->query($sql, [$id, $idUserAuth]);
    }

    function innerJoin ($user_id)
    {
        $sql = "SELECT p.id, p.platform, p.url_platform, p.pass_gen, u.email
                FROM {$this->table} AS p
                INNER JOIN {$this->tableRelations} AS u
                ON u.id = p.user_id
                WHERE p.user_id = ?";
        $this->query($sql, [$user_id]);

        return $this;
    }
}