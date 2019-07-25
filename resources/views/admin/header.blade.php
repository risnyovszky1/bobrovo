<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>


    <script type="text/javascript" src="/js/app.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,400,400i,700&amp;subset=latin-ext"
          rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/app.css">

    <link rel="icon" href="/img/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon"/>

    <!-- Include Editor style. -->
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.2/css/froala_editor.min.css' rel='stylesheet'
          type='text/css'/>
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.2/css/froala_style.min.css' rel='stylesheet'
          type='text/css'/>
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.2/css/plugins/code_view.min.css' rel='stylesheet'
          type='text/css'/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>

    <!-- Include JS file. -->
    <script type='text/javascript'
            src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.2/js/froala_editor.min.js'></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
    <script type='text/javascript'
            src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.2/js/plugins/font_size.min.js'></script>
    <script type='text/javascript'
            src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.2/js/plugins/paragraph_format.min.js'></script>
    <script type='text/javascript'
            src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.2/js/plugins/image.min.js'></script>
    <script type='text/javascript'
            src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.2/js/plugins/code_view.min.js'></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

</head>
<body>
<header id="header-admin">
    <nav class="navbar navbar-expand-sm navbar-dark bg-bobrovo-green">
        <a class="navbar-brand" href="{{ route('admin') }}">
            <img src="/img/logo-web.png" width="30" height="30" class="d-inline-block align-top mr-1"
                 alt="Bobrovo logo">
            Bobrovo
        </a>
        <button class="navbar-toggler bg-bobrovo-orange text-white border-white" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mt-2 mt-sm-0">
                <li class="nav-item">
                    <a class="btn btn-danger btn-sm nav-link" href="{{ route('logout') }}"><i
                                class="fas fa-sign-out-alt"></i> Odhlásiť</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
