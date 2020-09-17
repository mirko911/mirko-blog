<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http;

use App\Router\Request;
use App\Router\Response;
use App\Models\Post;
use App\Auth\Auth;
use Jenssegers\Blade\Blade;


class AdminPostController {
    
    public function __construct(){

    }
    
    public function list(Request $request) : Response{
        if(!Auth::isLoggedIn()){
            return (new Response())->redirect('/login')->withMessaage(['Not logged in']);
        }
        
        $posts = Post::query()->get();
        
        $blade = new Blade('../views', '../cache');
        
        $view = $blade->make('admin.post.list', ['posts' => $posts])->render();
        return (new Response())->response($view, 200);  

    }
    
    public function create(Request $request) : Response{
        if(!Auth::isLoggedIn()){
            return (new Response())->redirect('/login')->withMessaage(['Not logged in']);
        }
        
        $blade = new Blade('../views', '../cache');

        $view = $blade->make('admin.post.create', ['csrf_token' => $_SESSION['csrf_token']])->render();
        
        return (new Response())->response($view, 200);  

    }
    
    public function store(Request $request) : Response{
        if(!Auth::isLoggedIn()){
            return (new Response())->redirect('/login')->withMessaage(['Not logged in']);
        }
        
        $errors = [];
        if(empty($request->getRequest())){
            $errors[] = 'No Post Data';
            return (new Response())->redirect('/admin/post/create')->withMessaage($errors);
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
            return (new Response())->redirect('/admin/post/create')->withMessaage($errors);
        }
        
        $post = new Post();
        $post->fill($postData);
        $post->created_at = date('Y-m-d H:i:s');
        $post->updated_at = date('Y-m-d H:i:s');
        $post->save();
        
        return (new Response())->redirect('/admin/post')->withMessaage($errors);

    }
}