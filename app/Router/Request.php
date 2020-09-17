<?php

namespace App\Router;

class Request {
    public $query;
    public $request;
    public $cookies;
    public $session;
    public $server;
   
    public function __construct($query, $request, $cookies, $session, $server){
        $this->query = $query;
        $this->request = $request;
        $this->cookies = $cookies;
        $this->session = $session;
        $this->server = $server;
    }
    
    public function getMethod() : string {
        return $this->server['REQUEST_METHOD'];
    }
    
    public function hasQuery(string $string) : bool{
        return isset($this->query[$string]);
    }
    
    public function hasRequest(string $string) : bool{
        return isset($this->request[$string]);
    }
    
    public function getQuery() : array {
        return $this->query;
    }
    
    public function getRequest() : array {
        return $this->request;
    }
    
    public function getURL() : string{
        return $this->server['REQUEST_URI'];
    }
}