@extends('../../template')

@section('content')
<div class="row">
    <div class="col">
        <a class="btn btn-primary" href="/admin/user/create">Create new User</a>
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
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->status}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->created_at}}</td>
                        <td>-</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection