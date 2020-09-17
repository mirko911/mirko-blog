@extends('../../template')

@section('content')
<div class="row">
    <div class="col">
        <form action="/admin/user" method="post">
            <label for="name">Name</label>
            <input class="form-control" id="name" name="name" type="text" placeholder="Username">
           
            <label for="text">Password</label>
            <input class="form-control" id="text" name="password" type="password"/>
            
            <label for="text">Email</label>
            <input class="form-control" id="text" name="email" type="text"/>
            
            <input type="hidden" name="csrf" value="{{$csrf_token}}" />
            <button type="Submit" value="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection