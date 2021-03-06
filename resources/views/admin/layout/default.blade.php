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
        <meta name="title" content="Forge Admin is modern, responsive Material Admin Template.">
        <meta name="description" content="Forge Admin Material Admin Template is modern, responsive and based on Material Design by Google.It's Material Design Admin Template powered by MaterialCSS.">
        <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template, materialcss, admin pages, material CMS, Forge Admin template, resoponsive material admin">
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
        <link rel="stylesheet" href="{{ asset('css/dynamic.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/scrollbar/perfect-scrollbar.min.css') }}">
        <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/jquery.dataTables.min.css') }}">
        @yield('css')

        <style>
            .vertical-navigations .side-nav li a.active span, .vertical-navigations .side-nav li a.current span {
                color: #FFF;
                font-weight: 500 !important;
            }
        </style>
    </head>
    <body>
        @yield('appPre')
        <div id="app" sidebar="{{ Route::currentRouteName() == 'admin.pos.pos.view' ? 'iconized' : 'default' }}">
            <div id="preloader">
              <div class="preloader-center">
                <div class="dots-loader dot-circle"></div>
              </div>
            </div>
            <header>
                @include('admin.includes.header')
                @include('admin.includes.verticalnav')
                @include('admin.includes.horizontal')
                @include('admin.includes.notification')
            </header>
            <main>
                @yield('content')
                @include('admin.includes.footer')
            </main>
        </div>
        @yield('appPost')
        <!-- Scripts -->
        <script type="text/javascript" src="{{ asset('js/all.js') }}"></script>

        @yield('jsPreApp')
        {{-- APP AND INIT --}}
        <script src="{{ asset('js/forgeapp.js') }}"></script>
        <script src="{{ asset('js/init.js') }}"></script>
        <script src="{{ asset('plugins/datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
        @yield('jsPostApp')


        @if (session('test_bd', false))
            <script>
                $(document).ready(function(){
                    $('.full-top-nav').attr('style', 'height: 93px !important; ');
                });
            </script>
        @endif

        @yield('jsRightSideBar')
    </body>
</html>
