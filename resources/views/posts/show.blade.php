<!DOCTYPE html>
<x-app-layout>
    <x-slot name="header">
        　波予報
    </x-slot>
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
            <head>
                <meta charset="utf-8">
                <title>Blog</title>
                <!-- Fonts -->
                <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
            </head>
            <body>
            <h1><a href='/'>波予測サイト</a></h1>
                    <h2>{{ $post->location->name }}への投稿</h2>
                    <h3>日時</h3>
                    <p>{{$post->surf_time}}</p>
                    <h3>コメント</h3>
                    <p>{{$post->comment}}</p>
            </body>
        </html>
</x-app-layout>