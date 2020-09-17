<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace App\Models;

class User extends BaseModel{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    
    protected $table = "users";
    protected $fillable = ['status', 'name', 'password', 'email'];

}