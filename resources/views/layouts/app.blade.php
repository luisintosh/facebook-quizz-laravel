<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# game: http://ogp.me/ns/game#">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.seo')

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://use.fontawesome.com">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?v={{ filemtime( resource_path('sass/app.scss') ) }}" type="text/css" rel="stylesheet" media="screen,projection"/>
    @stack('styles')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        var basePath = '{{ route('home') }}';
    </script>
</head>
<body>
    <!-- navbar-->
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Navbar brand-->
                <a href="/" class="navbar-brand">
                    <img src="{{ asset('images/site/logo.png') }}" alt="{{ \App\Settings::get('site_name') }}" height="55">
                </a>
                <!-- Navbar toggler button-->
                <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right">Menu<i class="icon ion-md-list ml-2"></i></button>
                <div id="navbarSupportedContent" class="collapse navbar-collapse">
                    <ul class="navbar-nav mx-auto ml-auto">

                    </ul>
                    <ul class="navbar-nav">
                        @auth()
                            @if(\App\User::isAdminUser())
                                <li class="nav-item">
                                    <a href="{{ route('quizzes.index') }}" class="nav-link font-weight-bold mr-3">Quizzes</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('settings.index') }}" class="nav-link font-weight-bold mr-3">{{ __('Configuraciones') }}</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold mr-3" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li class="nav-item"><a href="{{ route('social.auth', 'facebook') }}" class="navbar-btn btn btn-primary"><i class="fab fa-facebook-square"></i> Conectar</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="page-holder">
        <section class="shape-1 shape-1-sm mt-sm-5">
            <div class="container">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                @yield('content')
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
        </section>
    </div>

    @include('layouts.footer')
</body>
</html>
