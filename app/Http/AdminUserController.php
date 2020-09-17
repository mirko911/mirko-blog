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


class AdminUserController {
    public function list(Request $request) : Response{
        if(!Auth::isLoggedIn()){
            return (new Response())->redirect('/login')->withMessaage(['Not logged in']);
        }
        
        $users = User::query()->get();
        
        $blade = new Blade('../views', '../cache');
        
        $view = $blade->make('admin.user.list', ['users' => $users])->render();
        
        return (new Response())->response($view, 200);  
    }
    
    public function create(Request $request) : Response{
        if(!Auth::isLoggedIn()){
            return (new Response())->redirect('/login')->withMessaage(['Not logged in']);
        }
        
        $blade = new Blade('../views', '../cache');

        $view = $blade->make('admin.user.create', ['csrf_token' => $_SESSION['csrf_token']])->render();
        
        return (new Response())->response($view, 200);  
    }
    
    public function store(Request $request) : Response{
        if(!Auth::isLoggedIn()){
            return (new Response())->redirect('/login')->withMessaage(['Not logged in']);
        }
        
        $errors = [];
        
        if(empty($request->getRequest())){
            $errors[] = 'No Post Data';
            return (new Response())->redirect('/admin/user/create')->withMessaage($errors);
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
            return (new Response())->redirect('/admin/user/create')->withMessaage($errors);
        }
        
        $user = new User();
        $user->fill($postData);
        $user->status = User::STATUS_ENABLED;
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();
        
        return (new Response())->redirect('/admin/user');

    }
}