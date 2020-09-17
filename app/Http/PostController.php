<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http;

use Jenssegers\Blade\Blade;

use App\Router\Request;
use App\Models\Post;

class PostController{    
    public function list(Request $request){
        $posts = Post::query()->get();
        
        $blade = new Blade('../views', '../cache');
        
        return $blade->make('posts', ['posts' => $posts])->render();
    }
}