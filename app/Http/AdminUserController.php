<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http;

use App\Router\Request;
use App\Models\User;
use Jenssegers\Blade\Blade;


class AdminUserController {
    public function list(Request $request){
        $users = User::query()->get();
        
        $blade = new Blade('../views', '../cache');
        
        return $blade->make('adminuser_list', ['users' => $users])->render();
    }
    
    public function create(Request $request){
        $blade = new Blade('../views', '../cache');

        return $blade->make('adminuser_create', ['csrf_token' => $_SESSION['csrf_token']])->render();
    }
    
    public function store(Request $request){
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
        
        if(!isset($postData['email']) || $postData['email'] === ''){
            $errors[] = "email is required";
        }
        
        
        
        $postData['name'] = filter_var($postData['name'], FILTER_SANITIZE_STRING);
        $postData['email'] = filter_var($postData['email'], FILTER_SANITIZE_EMAIL);
        $postData['email'] = filter_var($postData['email'], FILTER_VALIDATE_EMAIL);

        if($postData['email'] === false){
            $errors[] = "email is invalid";
        }
        
        $postData['password'] = password_hash($postData['password'], PASSWORD_DEFAULT );
        
        

        if(!empty($errors)){
            //Redirect to create with errors,
            dd($errors);
        }
        
        $user = new User();
        $user->fill($postData);
        $user->status = User::STATUS_ENABLED;
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();
        
    }
}