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
                <form action="/posts" method="post" >
                    @csrf
                    <select name="location_id" placeholder="ロケーション">
                        @foreach($location as $location)
                            <option value="{{ $location->id }}">{{$location->name}}</option>
                        @endforeach
                    </select>
                    <input type="datetime-local" name="surf_time" placeholder="サーフィンした日付">
                    <textarea name="comment" placeholder="今日波はどうでしてか"></textarea>
                    <input type="submit" value="store">
                </form>
            </body>
        </html>
</x-app-layout>