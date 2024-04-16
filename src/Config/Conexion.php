<?php

namespace App\Config;

use \PDO;
use PDOException;

class Conexion
{

	protected $db_host 		= "mysqldb";
	protected $db_user 		= "root";
	protected $db_pass 		= "123456";
	protected $db_dbname 	= "phpslim";
	protected $db_port 		= 3306;

	function connect() {
		try {

			$pdo = "mysql:host={$this->db_host};port={$this->db_port};dbname={$this->db_dbname}";
			$options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $cnx = new PDO($pdo, $this->db_user, $this->db_pass, $options);

            return $cnx;
		} catch(PDOException $e) {
			print_r("error de conexion: {$e->getMessage()}") . "\n";
            print_r("error en la linea: {$e->getLine()}") . "\n";
		}
	}
}