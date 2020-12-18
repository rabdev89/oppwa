<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{ env('GOOGLE_ANALYTICS') }}');
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('pageTitle') | Zoho Books Payment </title>
    <meta name="description" content="">
    <meta name="tags" content="">

    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js')}}"></script>
    <script src="{{ asset('https://oss.maxcdn.com/respond/1.4.2/respond.min.js')}}"></script>
    <![endif]-->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png')}}">
    <!-- <link rel="manifest" href="{{ asset('favicons/manifest.json')}}"> -->
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicons/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    @yield('css')
    <style>
    /*
    * Globals
    */

    /* Links */
    a,
    a:focus,
    a:hover {
    color: #fff;
    }


    /*
    * Base structure
    */

    html,
    body {
    height: 100%;
    }

    .cover-container {
    max-width: 42em;
    }


    /*
    * Header
    */
    .masthead {
        margin-bottom: 2rem;
    }

    .masthead-brand {
        margin-bottom: 0;
    }

    .masthead-brand img {
        width: 50%;
    }

    .masthead .inner { display: flex }

    .nav-masthead .active {
        color: #fff;
        border-bottom-color: #fff;
    }

    @media (min-width: 48em) {
        .masthead-brand {
            float: left;
        }
        .nav-masthead {
            float: right;
        }
    }


    /*
    * Cover
    */
    .cover {
        padding: 0 1.5rem;
    }
    .cover .btn-lg {
        padding: .75rem 1.25rem;
        font-weight: 700;
    }


    /*
    * Footer
    */
    .mastfoot {
        color: rgba(255, 255, 255, .5);
    }
    </style>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js') }}"></script>
    <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
<noscript>
    <p class="alert alert-danger">
        You need to turn on your javascript. Some functionality will not work if this is disabled.
        <a href="https://www.enable-javascript.com/" target="_blank">Read more</a>
    </p>
</noscript>
 <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="masthead">
    <div class="inner">
      <h3 class="masthead-brand"><img src=" @yield('merchant_logo')" alt=" @yield('merchant_name')"></h3>
      <nav class="nav nav-masthead justify-content-center">
        <h1>@yield('merchant_name')</h1>
      </nav>
    </div>
  </header>

  <main role="main" class="container">
     @yield('content')
  </main>

  <footer class="mastfoot mt-auto text-center">
    <div class="inner">
      <p>Copyright © 2020 AltPayNet</p>
    </div>
  </footer>
</div>


@yield('js')
</body>
</html>
