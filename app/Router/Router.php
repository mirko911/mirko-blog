<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Router;

use App\Router\Response;

class Router{
    private static $routes = [];
    private $routeNotFound = null;
    private $methodNotAllowed = null;
    
    public static function add(string $expression, string $callback, string $method = 'get') : void {
        self::$routes[] = [
            'path' => $expression,
            'callback' => $callback,
            'method' => $method
        ];
    }
    
    public function setRouteNotFound(callable $callback) : void{
        $this->routeNotFound = $callback;
    }
    
    public function setMethodNowAllowed(callable $callback) : void{
        $this->methodNotAllowed = $callback;
    }
    
    public function handleRequest(Request $request) : Response{
        $method = strtolower($request->getMethod());
        $url = $request->getURL();
        
        foreach(static::$routes as $route){
            if($url === $route['path'] && $method === $route['method']){
                [$controller, $action] = explode('@', $route['callback']);
                
                $controllerNamespace = "App\\Http\\$controller";
                $controllerInstance = new $controllerNamespace();
                return $controllerInstance->$action($request);
            }
        }
    }
    
    
}