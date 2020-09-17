@extends('../../template')

@section('content')
<div class="row">
    <div class="col">
        <a class="btn btn-primary" href="/admin/post/create">Create new Post</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>{{$post->id}}</td>
                        <td>{{$post->title}}</td>
                        <td>{{$post->created_at}}</td>
                        <td>-</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection