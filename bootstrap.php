<?php

echo "Bootstrapping";


//Dev-Tool for development. Will be removed in final project
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

