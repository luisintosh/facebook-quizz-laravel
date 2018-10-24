<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
</head>
<body>
    <!-- navbar-->
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Navbar brand-->
                <a href="/" class="navbar-brand font-weight-bold">🤪 Facebook Quizz</a>
                <!-- Navbar toggler button-->
                <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right">Menu<i class="icon ion-md-list ml-2"></i></button>
                <div id="navbarSupportedContent" class="collapse navbar-collapse">
                    <ul class="navbar-nav mx-auto ml-auto">

                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="#" class="nav-link font-weight-bold mr-3">Quizzes</a></li>
                        <li class="nav-item"><a href="#" class="navbar-btn btn btn-primary"><i class="fab fa-facebook-square"></i> Conectar</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="page-holder">
        <section class="text-center mt-sm-4">
            -- ADS --
        </section>
        <section class="shape-1 shape-1-sm mt-sm-4">
            <div class="container">
                <div class="container">
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->
                @yield('content')
                <!-- ============================================================== -->
                    <!-- End PAge Content -->
                    <!-- ============================================================== -->
                </div>
            </div>
        </section>
    </div>
    <footer class="footer mt-sm-4">
        <div class="container text-center">
            <!-- Copyrights-->
            <div class="copyrights">
                <p class="copyrights-text mb-0">Desarrollado por <a href="https://www.tequilapps.com" target="_blank" class="copyrights-link">Tequilapps</a></p>
            </div>
        </div>
    </footer>


    <!--  Scripts-->
    <script src="{{ asset('js/app.js') }}?v={{ filemtime( resource_path('js/app.js') ) }}"></script>
    @stack('scripts')
</body>
</html>
