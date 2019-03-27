<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="/css/app.css">

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
                <a class="btn btn-danger btn-sm" href="{{ route('logout_student') }}"><i class="fas fa-sign-out-alt"></i> Odhlásiť</a>
              </li>
            </ul>
          </div>
        </nav>
    </header>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
            <code class="mt-4">
                <pre>
                    @php
                        echo Auth::user()
                    @endphp
                </pre>
            </code>

            <code class="mt-4">
                <pre>
                    @php
                        var_dump($groups)
                    @endphp
                </pre>
            </code>

            <code class="mt-4">
                <pre>
                    @php
                        var_dump($tests)
                    @endphp
                </pre>
            </code>
        </div>
      </div>
    </div>

    

    
</body>
</html>