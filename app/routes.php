<?php

use App\Router\Router;

Router::add('/test', 'TestController@test');
Router::add('/', 'PostController@list');
Router::add('/post/1', 'PostController@show');
Router::add('/login', 'LoginController@show');
Router::add('/login', 'LoginController@login', 'post');
Router::add('/admin/post', 'AdminPostController@list');
Router::add('/admin/post/create', 'AdminPostController@create');
Router::add('/admin/post', 'AdminPostController@store', 'post');
        