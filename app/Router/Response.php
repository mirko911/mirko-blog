<?php

namespace App\Router;

class Response{
    private $messages = [];
    private $response = "";
    private $redirectURL = "";
    private $status = 200;
    
    public function __construct() {
        $_SESSION['messages'] = [];
    }
    
    public function redirect(string $url) : Response{
        $this->redirectURL = $url;
        
        return $this;
    }
    
    public function withMessaage($messages) : Response{
        $this->messages = $messages;
        
        return $this;
    }
    
    public function response(string $response, int $status = 200) : Response{
        $this->response = $response;
        $this->status = $status;
        
        return $this;
    }
    
    public function setStatus($status) : Response{
        $this->status = $status;
        
        return $this;
    }
    
    public function handleResponse() : void{
        $_SESSION['messages'] = $this->messages;
   
        
        http_response_code($this->status);
        
        if($this->redirectURL !== ""){
            header("Location: {$this->redirectURL}");
            die();
        }
        
        echo $this->response;
    }
    
}