<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1><a href='/'>波予測サイト</a></h1>
            <h2>神奈川</h2>
                @foreach($area as $area)
                    <h3><a href='areas/{{$area->id}}'>{{$area->name}}</a></h3>
                @endforeach
    </body>
</html>