@extends('template')

@section('content')
<div class="row">
    <div class="col">
        @foreach($posts as $post)
        <div class="card" style="width: 18rem;" data-post="{{$post->id}}">
            <div class="card-body">
                <h5 class="card-title">{{$post->title}}  <small>Date: {{$post->created_at}}</h5>
              <p class="card-text">{{$post->content}}</p>
              <a href="#" class="card-link"> <a href="/post/{{$post->id}}">Read more</a></a>
            </div>
          </div>
        @endforeach
    </div>
</div>
<div class="row">
    <div class="col">
        
        Links:
        <a href="/admin/post">Admin List Posts</a>
        <a href="/admin/user">Admin List User</a>

        <!--
Router::add('/test', 'TestController@test');
Router::add('/', 'PostController@list');
Router::add('/post/1', 'PostController@show');
Router::add('/login', 'LoginController@show');
Router::add('/login', 'LoginController@login', 'post');
Router::add('/admin/post', 'AdminPostController@index');
Router::add('/admin/post/create', 'AdminPostController@create');
Router::add('/admin/post/', 'AdminPostController@store', 'post');
        -->
    </div>
    
</div>
@endsection

