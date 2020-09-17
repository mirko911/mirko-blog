<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http;

use App\Router\Request;
use App\Router\Response;
use App\Models\User;
use App\Auth\Auth;

use Jenssegers\Blade\Blade;

class AuthController {
    public function login(Request $request) : Response{
        $blade = new Blade('../views', '../cache');
        
        $view = $blade->make('auth.login',  ['csrf_token' => $_SESSION['csrf_token']])->render();
        return (new Response())->response($view, 200);  
    }
    
    public function loginPost(Request $request) : Response{
        $errors = [];
        if(empty($request->getRequest())){
            $errors[] = 'No Post Data';
            return (new Response())->redirect('/login')->withMessaage($errors);
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
        
        if(!empty($errors)){
            return (new Response())->redirect('/login')->withMessaage($errors);
        }
        
    
        $postData['name'] = filter_var($postData['name'], FILTER_SANITIZE_STRING);

        $user = User::query()->where(['name','=', $postData['name']])->first();
        
        if($user === null){
            $errors[] = 'User or password wrong';
            return (new Response())->redirect('/login')->withMessaage($errors);

        }
        
        if(password_verify($postData['password'], $user->password)){
            Auth::loginUsingID($user->id);
            echo "Login successfull";
        }else{
            $errors[] = 'User or password wrong';
            return (new Response())->redirect('/login')->withMessaage($errors);

        }

        return (new Response())->redirect('/')->withMessaage(['Login Successful']);
    }
    
    public function logout() : Response{
        Auth::logout();
        return (new Response())->redirect('/')->withMessaage(['Logout Successful']);
    }
}