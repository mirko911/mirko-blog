@extends('../../template')

@section('content')
<div class="row">
    <div class="col">
        <form action="/admin/post" method="post">
            <label for="title">Title</label>
            <input class="form-control" id="title" name="title" type="text" placeholder="title">
           
            <label for="text">Post</label>
            <textarea class="form-control" id="text" name="content" type="text"></textarea>
            
            <input type="hidden" name="csrf" value="{{$csrf_token}}" />
            <button type="Submit" value="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection