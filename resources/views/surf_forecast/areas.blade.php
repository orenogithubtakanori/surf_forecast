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
                <h2>{{$area->name}}</h2>
                @foreach($location as $location)
                    @if($location->area_id === $area->id)
                        <h3><a href='../locations/{{$location->id}}'>{{$location->name}}</a></h3>
                    @endif
                @endforeach
            </body>
        </html>
</x-app-layout>