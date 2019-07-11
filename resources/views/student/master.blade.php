<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="icon" href="/img/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon"/>

    <script type="text/javascript" src="/js/app.js"></script>
</head>
<body class="bg-bobrovo-orange-light">
    <header id="header-admin">
        <nav class="navbar navbar-expand-lg navbar-dark bg-bobrovo-orange">
          <a class="navbar-brand" href="{{ route('student_home') }}"> 
              <img src="/img/logo-web.png" width="30" height="30" class="d-inline-block align-top mr-1" alt="Bobrovo logo"> 
              {{ __('student.Bobrovo') }}
          </a>
          <button class="navbar-toggler bg-bobrovo-green-light text-white border-white" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
  
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a href="{{ route('tests_student') }}" class="nav-link"><i class="fas fa-file-alt"></i> {{  __('student.Tests') }}</a>
              </li>
              <li class="nav-item dropdown">
                <a href="{{ route('groups_student') }}" class="nav-link"><i class="fas fa-users"></i> {{  __('student.Groups') }}</a>
              </li>
              <li class="nav-item">
                <a class="btn btn-danger btn-sm nav-link ml-2" href="{{ route('logout_student') }}"><i class="fas fa-sign-out-alt"></i> {{  __('student.Logout') }}</a>
              </li>
            </ul>
          </div>
        </nav>
    </header>


    <div id="root" class="full-height-lg">
      @yield('content')
    </div>

    <footer id="footer-bobrovo">
      <div class="post-footer bg-dark text-light pt-2 pb-2">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 white-links">
              <p class="lead mb-0">
                Stránku vytvoril <a href="mailto:risnyo96@gmail.com"><strong>András Risnyovszký</strong></a> ako bakalárskú prácu v FMFI UK <sup>&copy;</sup>
              </p>
            </div>
          </div>
        </div>
      </div>
    </footer>
    
</body>
</html>