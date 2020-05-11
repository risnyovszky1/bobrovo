<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->

    <script type="text/javascript" src="/js/app.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,400,400i,700&amp;subset=latin-ext"
          rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">

    <link rel="icon" href="/img/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon"/>
</head>
<body>
<header id="header-bobrovo">
    <nav class="navbar navbar-expand-sm navbar-dark bg-bobrovo-green">
        <a class="navbar-brand" href="{{ route('index') }}">
            <img src="/img/logo-web.png" width="30" height="30" class="d-inline-block align-top mr-1"
                 alt="Bobrovo logo">
            Bobrovo</a>
        <button class="navbar-toggler bg-bobrovo-orange text-white border-white" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item dropdown {{ (Request::is('prihlasenie-ucitel') || Request::is('prihlasenie-student') ? 'active' : '') }}">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-sign-in-alt"></i> Prihlásiť
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item {{ (Request::is('prihlasenie-student') ? 'active' : '') }}"
                               href="{{ route('login_student') }}"><i class="fas fa-user-graduate"></i> Ako študent</a>
                            <a class="dropdown-item {{ (Request::is('prihlasenie-ucitel') ? 'active' : '') }}"
                               href="{{ route('login_teacher') }}"><i class="fas fa-user"></i> Ako učiteľ</a>
                        </div>
                    </li>

                    <li class="nav-item {{ (Request::is('registracia') ? 'active' : '') }}">
                        <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Registrácia</a>
                    </li>
                @else
                    @auth('web')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin') }}"><i class="fas fa-user-lock"></i> Admin</a>
                        </li>
                    @endauth
                    @auth('bobor')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student_home') }}"><i class="fas fa-user-lock"></i> Nástenka</a>
                        </li>
                    @endauth
                @endguest
            </ul>
        </div>
    </nav>
</header>
