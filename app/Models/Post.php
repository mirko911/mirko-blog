<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

class Post extends BaseModel{
    protected $table = "posts";
    protected $fillable = ['title', 'content', 'user_id'];

}