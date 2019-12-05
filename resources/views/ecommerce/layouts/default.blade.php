<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <link rel="icon" href="{{ url('images/favicon/favicon-32x32.png') }}" sizes="32x32">
        <link rel="apple-touch-icon-precomposed" href="{{ url('images/favicon/favicon-32x32.png') }}">
        <!-- META DATA-->
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="title" content="E-commerce.">
        <meta name="description" content="E-Commerce.">
        <meta name="keywords" content="e-commerce">
        <meta name="msapplication-TileColor" content="#FFFFFF">
        <meta name="msapplication-TileImage" content="{{ url('images/favicon/favicon-32x32.png') }}">
        <meta name="theme-color" content="#2a56c6">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Werp') }} - @yield('title') </title>
        <!-- FONTS-->
        @if ($noInternet = true)
            <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
            <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
        @else
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Inconsolata" type="text/css">
            <link rel="stylesheet" href="http://fonts.googleapis.com/icon?family=Material+Icons">
        @endif
        <!-- Styles -->
        
        {{-- <link rel="stylesheet" href="{{ asset('css/dynamic.css') }}">
            <link rel="stylesheet" href="{{ asset('plugins/scrollbar/perfect-scrollbar.min.css') }}"> --}}

        <link href="{{ asset('css/ecommerce/store-app.css') }}" rel="stylesheet">
        
        @yield('css')

        <style>
            .vertical-navigations .side-nav li a.active span, .vertical-navigations .side-nav li a.current span {
                color: #FFF;
                font-weight: 500 !important;
            }
        </style>
    </head>
    <body class="ecommerce">
        @yield('appPre')
        <div id="app" >
            <div id="preloader">
              <div class="preloader-center">
                <div class="dots-loader dot-circle"></div>
              </div>
            </div>
            <header>
                @include('ecommerce.partials.header')
            </header>
            <main style="padding-left: 0px;">
                @yield('content')
                @include('ecommerce.partials.footer')
            </main>
        </div>
        @yield('appPost')
        <!-- Scripts -->
        
        <script type="text/javascript" src="{{ asset('js/libs.js') }}"></script>

        @yield('jsPreApp')
        {{-- APP AND INIT --}}
        <script src="{{ asset('js/ecommerce-app.js') }}"></script>
        {{-- 
        <script src="{{ asset('js/init.js') }}"></script>
         --}}
        @yield('jsPostApp')


        @if (session('test_bd', false))
            <script>
                $(document).ready(function(){
                    $('.full-top-nav').attr('style', 'height: 93px !important; ');
                });
            </script>
        @endif

    </body>
</html>
