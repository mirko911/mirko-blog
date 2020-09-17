<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use App\Database\Query;

class BaseModel {
    protected $table;
    protected $database = "default";
    protected $attributes = [];
    /**
     *
     * @var \App\Database\Mysql
     */
    protected $connection;
    protected $fillable = [];
    
    public static $database_connections;
    
    public function __construct(?array $attributes = null){
        $this->attributes = $attributes;
        $this->selectConnection();
    }
    
    public static function setDatabaseConnections(array $connections) : void{
        static::$database_connections = $connections;
    }
    
    public function selectConnection() : void{
        if(!isset(static::$database_connections[$this->database])){
            throw \Exception("Can't find database connection");
        }
        $this->connection = static::$database_connections[$this->database];
    }
    
    public function __get(string $key){
        return $this->attributes[$key];
    }
    
    public function __set(string $key, $value){
        $this->attributes[$key] = $value;
    }
    
    public static function query() : Query{
        $model = new static;
        return $model->createQuery();
    }
    
    public function createQuery() : Query {
        $query = new Query($this->connection);
        $query->setFrom($this->table);
        $query->setModel(static::class);
        
        return $query;
    }
    
    public function fill(array $attributes) : void {
        foreach($attributes as $key => $value){
            if(in_array($key, $this->fillable)){
                $this->attributes[$key] = $value;
            }
        }
    }
    
    public function save() : void{
        $keyString = implode(",", array_keys($this->attributes));
        $bindString = "(" . implode(",", array_fill(0, count($this->attributes), '?')) . ')';
        $query = "INSERT INTO {$this->table} ({$keyString}) VALUES $bindString";
        
        $this->connection->prepareStaatement($query);
        
        $i = 1;
        foreach(array_values($this->attributes) as $value){
            if(is_bool($value)){
                $this->connection->bindValue($i++, $value, \PDO::PARAM_BOOL);
            }
            else if(is_int($value) || is_float(($value))){
                $this->connection->bindValue($i++, $value, \PDO::PARAM_INT);
            }else{
                $this->connection->bindValue($i++, $value, \PDO::PARAM_STR);
            }
        }
        
        $this->connection->execute(false);
        
       // $valueStrnig = implode(",", array_values($this->attributes));
        
        
    }
}