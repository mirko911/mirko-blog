<?php


namespace App\Auth;

use App\Models\User;

class Auth{
    public static function loginUsingID(int $id) : void{
        $_SESSION['user_id'] = $id;
    }
    
    public static function getUser() : ?User{
        if(static::isLoggedIn())
            return User::query()->where(['id', '=', $_SESSION['user_id']])->first();
        else
            return null;
    }
    
    public static function isLoggedIn() : bool{
        return (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0);
    }
    
    public static function logout() : void{
        $_SESSION['user_id'] = -1;
        unset($_SESSION['user_id']);
    }
}