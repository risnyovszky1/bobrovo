<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="icon" href="/img/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon"/>

    <script type="text/javascript" src="/js/app.js"></script>
</head>
<body>
    <header id="header-admin">
        <nav class="navbar navbar-expand-lg navbar-dark bg-bobrovo-green">
          <a class="navbar-brand" href="{{ route('student_home') }}"> 
              <img src="/img/logo-web.png" width="30" height="30" class="d-inline-block align-top mr-1" alt="Bobrovo logo"> 
              Bobrovo
          </a>
          <button class="navbar-toggler bg-bobrovo-orange text-white border-white" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
  
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a href="{{ route('tests_student') }}" class="nav-link"><i class="fas fa-file-alt"></i> Testy</a>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link"><i class="fas fa-users"></i> Skupiny</a>
              </li>
              <li class="nav-item">
                <a class="btn btn-danger btn-sm nav-link ml-2" href="{{ route('logout_student') }}"><i class="fas fa-sign-out-alt"></i> Odhlásiť</a>
              </li>
            </ul>
          </div>
        </nav>
    </header>


    <div id="root">
      @yield('content')
    </div>
    
</body>
</html>