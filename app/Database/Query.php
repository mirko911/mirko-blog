<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Database;

use App\Models\BaseModel;

class Query {
    /**
     *
     * @var Mysql
     */
    private $connection;
    
    private $model;
    
    
    private $where = [];
    private $from;
    private $order = [];
    
    public function __construct(Mysql $connection) {
        $this->connection = $connection;
    }
    
    public function setModel(string $model) : Query{
        $this->model = $model;
        
        return $this;
    }
    
    public function where(array $array) : Query{
        $this->where[] = $array;
        
        return $this;
    }
    
    public function setFrom(string $from) : Query{
        $this->from = $from;
      
        return $this;
    }
    
    public function setOrder(string $column, string $order = "ASC") : Query{
        $this->order[] = ['column' => $column, 'order' => $order];
        
        return $this;
    }
    
    private function buildQuery() : array {
        $whereString = "";
        $bindings = [];
        
        if(!empty($this->where)){
            $whereString = "WHERE 1 AND ";
            foreach($this->where as $condition){
                [$column, $operator, $value] = $condition;
                
                $bindings[":col_{$column}"] = $value;
                $whereString .= "{$column} {$operator} :col_{$column} AND";
            }
            $whereString = substr($whereString, 0, -4);
        }
        
        $orderString = "";
        if(!empty($this->order)){
            $orderString = "ORDER BY ";
            foreach($this->order as $order){
                $orderString .= "{$order['column']} {$order['order']},";
            }
            $orderString = substr($orderString, 0, -1);
        }
        
        $query = "SELECT * FROM {$this->from} {$whereString} {$orderString}";
        
        return [$query, $bindings];
    }
    
    public function first() : ?BaseModel {
        [$query, $bindings] = $this->buildQuery();
        
        $query .= " LIMIT 0,1";
        
        $this->connection->prepareStaatement($query);
        foreach($bindings as $key => $value){
            if(is_bool($value)){
                $this->connection->bindValue($key, $value, \PDO::PARAM_BOOL);
            }
            else if(is_int($value) || is_float(($value))){
                $this->connection->bindValue($key, $value, \PDO::PARAM_INT);
            }else{
                $this->connection->bindValue($key, $value, \PDO::PARAM_STR);
            }
        }
        
        $result = $this->connection->execute();
        
        if(empty($result)){
            return null;
        }else{
            return new $this->model($result[0]);
        }        
    }
    
    public function get() : array {
        [$query, $bindings] = $this->buildQuery();
                
        $this->connection->prepareStaatement($query);
        foreach($bindings as $key => $value){
            if(is_bool($value)){
                $this->connection->bindValue($key, $value, \PDO::PARAM_BOOL);
            }
            else if(is_int($value) || is_float(($value))){
                $this->connection->bindValue($key, $value, \PDO::PARAM_INT);
            }else{
                $this->connection->bindValue($key, $value, \PDO::PARAM_STR);
            }
        }
        
        $result = $this->connection->execute();
        
        $response = [];
        foreach($result as $row){
            $response[] = new $this->model($row);
        }
        
        return $response;        
    }
    
    
}