@extends('template')

@section('content')
<div class="row">
    <div class="col">
        @foreach($posts as $post)
        <article class="post" data-post="{{$post->id}}">
            <div class="post-title">{{$post->title}}</div>
            <div class="post-content">{{$post->content}}
                <a href="/post/{{$post->id}}">Read more</a>
            </div>
        </article>
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

