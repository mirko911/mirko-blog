<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http;

use App\Router\Request;
use App\Models\User;
use App\Auth\Auth;

use Jenssegers\Blade\Blade;

class AuthController {
    public function login(Request $request){
        $blade = new Blade('../views', '../cache');
        
        return $blade->make('auth_login',  ['csrf_token' => $_SESSION['csrf_token']])->render();
    }
    
    public function loginPost(Request $request){
        $errors = [];
        if(empty($request->getRequest())){
            $errors[] = 'No Post Data';
            dd("No content");
        }
        
        $postData = $request->getRequest();
        
        //Input Validation
        if(!isset($postData['csrf']) || $postData['csrf'] != $_SESSION['csrf_token']){
            $errors[] = "CSRF wrong";
        }

        if(!isset($postData['name']) || $postData['name'] === ''){
           $errors[] = "Name is required";
        }
        if(!isset($postData['password']) || $postData['password'] === ''){
            $errors[] = "password is required";
        }
        
        
    
        $postData['name'] = filter_var($postData['name'], FILTER_SANITIZE_STRING);

        $user = User::query()->where(['name','=', $postData['name']])->first();
        
        if($user === null){
            $errors[] = 'User or password wrong';
        }
        
        if(password_verify($postData['password'], $user->password)){
            Auth::loginUsingID($user->id);
            echo "Login successfull";
        }else{
            $errors[] = 'User or password wrong';
        }


        if(!empty($errors)){
            //Redirect to create with errors,
            dd($errors);
        }
       

    }
    
    public function logout(){
        Auth::logout();
        echo "Logout";
    }
}