<?php

use App\Database\Mysql;
use App\Router\Router;
use App\Router\Request;

//Dev-Tool for development. Will be removed in final project
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


try {
    session_start();
    
    $database_connections = [];
    $database_config = include_once __DIR__ . '/config/database.php';
    foreach($database_config as $key => $value){
        $database_connections[$key] = new Mysql($value);
    }

    $request = new Request($_GET, $_POST, $_COOKIE, $_SESSION, $_SERVER);
    
    include_once __DIR__ . '/app/routes.php';
    $router = new Router();
    $router->handleRequest($request);
    
    $query = new App\Database\Query($database_connections['default']);
    $result = $query->setFrom('posts')->get();
    dd($result);
} catch (Exception $ex) {
    $whoops->handleException($ex);
}