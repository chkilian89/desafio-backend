<!doctype html>
<html lang="{{ App::getLocale() }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <link rel="shortcut icon" href="{{ asset('assets/chktecnologia/img/favicon.png') }}" type="image/x-icon">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta http-equiv="refresh" content="3600;url={{ Config::get('app.url') }}">
        @yield('metatags')
        <!-- Bootstrap CSS -->
        @include('painel.shared.head')
        <title>@yield('title')</title>
        @yield('custom_head')
    </head>
    <body class="sb-nav-fixed" style="padding-bottom: 60px;">

        @yield('maincontainer')

        @include('painel.shared.footer')
        @yield('footerjs')
        @include('default.loading')
    </body>
</html>

