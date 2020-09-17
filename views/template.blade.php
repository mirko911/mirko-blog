<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

    <title>Blog</title>
  </head>
  <body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Mirko Blog</a>
  @if(App\Auth\Auth::isLoggedIn()):
  <small>Logged in as {{App\Auth\Auth::getUser()->name}}</small>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
  </div>
  @else
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <a href="/login" class="btn btn-primary btn-sm">Login</a>
  </div>
  @endif


</nav>
      @if(isset($_SESSION['messages']))
        @foreach($_SESSION['messages'] as $message)
        <div class="alert alert-warning">
            {{$message}}
        </div>
        @endforeach
      @endif
      
      
      <div class="container">
          @yield('content')
      </div>

    <!-- Optional JavaScript -->
    <!-- Popper.js first, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  </body>
</html>