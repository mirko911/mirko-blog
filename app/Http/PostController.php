<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http;

use App\Router\Request;

class PostController{
    public function list(Request $request){
        echo "Index  workls";
    }
}