<?php

echo "Bootstrapping";

use App\Database\Mysql;

//Dev-Tool for development. Will be removed in final project
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


try {
    $database_connections = [];
    $database_config = include_once __DIR__ . '/config/database.php';
    foreach($database_config as $key => $value){
        $database_connections[$key] = new Mysql($value);
    }
    
    $default = $database_connections['default'];
    $default->prepareStaatement('SELECT * FROM posts WHERE id = 1');
    $result = $default->execute();
    dd($result);
    dd($database_config);
} catch (Exception $ex) {
    $whoops->handleException($ex);
}