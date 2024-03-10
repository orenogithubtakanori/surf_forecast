<!DOCTYPE html>
<x-app-layout>
    <x-slot name="header">
        　TOP
    </x-slot>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="utf-8">
            <title>Blog</title>
            <!-- Fonts -->
            <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        </head>
        <body>
            <h1>波予測サイト</h1>
                <h2>サーフスポットを探す</h2>
                    <h3>関東</h3>
                        <h4><a href='/prefectures'>神奈川</a></h4>
                        <h4>千葉</h4>
                <h2>波の感想をシェアする</h2>
                    <a href="/posts/create">投稿する</a>
        </body>
    </html>
</x-app-layout>