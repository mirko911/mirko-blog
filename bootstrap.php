<?php

use App\Database\Mysql;
use App\Router\Router;
use App\Router\Request;
use App\Models\BaseModel;

try {
    session_start();
    
    $app_config = include_once __DIR__ . '/config/app.php';

    
    //Fake CSRF Token //@todo: move to login
    if(!isset($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = uniqid('', true);
    }
    
    $database_connections = [];
    $database_config = include_once __DIR__ . '/config/database.php';
    foreach($database_config as $key => $value){
        $database_connections[$key] = new Mysql($value);
    }
    BaseModel::setDatabaseConnections($database_connections);

    $request = new Request($_GET, $_POST, $_COOKIE, $_SESSION, $_SERVER);
    
    include_once __DIR__ . '/app/routes.php';
    $router = new Router();
    $router->handleRequest($request)
            ->handleResponse();
    
} catch (Exception $ex) {
    $response = new App\Router\Response();
    if($app_config['debug']){
            $response->response($ex->getMessage(), 500);
    }else{
            $response->response("S.th went wrong", 500);
    }
    $response->handleResponse();
}