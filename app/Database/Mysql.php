<?php

namespace App\Database;

use PDO;

class Mysql{
    
    /**
     * Database Connection Handle
     * 
     * @var \PDO
     */
    private $dbCon = null;
    
    
    /**
     * SQL Statement
     * 
     * @var \PDOStatement 
     */
    private $stmt = null;
    
    public function __construct($data){
          $attributes = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ];
        
        $this->dbCon = new PDO("mysql:host={$data['host']};dbname={$data['database']};charset=utf8mb4", $data['username'], $data['password'], $attributes);
    }
    
    public function prepareStaatement(string $sql) : void {
        $this->stmt = $this->dbCon->prepare($sql);
    }
    
    public function bindValue(string $key, $value, ?int $type = null) : void {
        if($this->stmt === null){
            throw \Exception("Can't bind value without a statement exception");
        }
        $this->stmt->bindValue($key, $value, $type);
    }
    
    public function execute() : ?array {
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}