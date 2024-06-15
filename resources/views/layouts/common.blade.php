<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </heade>
    <body>
        @include('parts.header')
        @yield('content')
    </body>
    <style>
        body{
            margin: 0px; /* bodyの外側の余白を指定する */
        }
    </style>
</html>