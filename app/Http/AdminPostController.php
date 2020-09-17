<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http;

use App\Router\Request;
use App\Models\Post;
use Jenssegers\Blade\Blade;


class AdminPostController {
    
    public function __construct(){
        if(!Auth::isLoggedIn()){
            dd("Not logged in");
        }
    }
    
    public function list(Request $request){
        $posts = Post::query()->get();
        
        $blade = new Blade('../views', '../cache');
        
        return $blade->make('adminpost_list', ['posts' => $posts])->render();
    }
    
    public function create(Request $request){
        $blade = new Blade('../views', '../cache');

        return $blade->make('adminpost_create', ['csrf_token' => $_SESSION['csrf_token']])->render();
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

        if(!isset($postData['title']) || $postData['title'] === ''){
           $errors[] = "Title is required";
        }
        if(!isset($postData['content']) || $postData['content'] === ''){
            $errors[] = "Text is required";
        }
        
        $postData['title'] = filter_var($postData['title'], FILTER_SANITIZE_STRING);
        $postData['content'] = filter_var($postData['content'], FILTER_SANITIZE_STRING);
        
        if(!empty($errors)){
            //Redirect to create with errors,
            dd($errors);
        }
        
        $post = new Post();
        $post->fill($postData);
        $post->created_at = date('Y-m-d H:i:s');
        $post->updated_at = date('Y-m-d H:i:s');
        $post->save();
        dd($post);
    }
}