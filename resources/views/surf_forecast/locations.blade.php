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
        <h1>{{$location->name}}</h1>
            @if(request()->has('level') && request()->get('level') === '1')
                <p>上級者</p>
            @elseif(request()->has('level') && request()->get('level') === '2')
                <p>中級者</p>
            @elseif(request()->has('level') && request()->get('level') === '3')
                <p>初級者</p>
            @else
                <p>中級者</p>
            @endif
            <form name="formlink">
            <select name="selectlink" class="selectlink" onchange="if(document.formlink.selectlink.value){location.href=document.formlink.selectlink.value;}">
            <option>選択してください</option>
            <option value="?level=3">初級者</option>
            <option value="?level=2">中級者</option>
            <option value="?level=1">上級者</option>
        </select>
        <h2>波予報</h2>
        @foreach($score as $score)
            @if(request()->has('level') && request()->get('level') === '1')
                @if($score->location_id === $location->id && $score->surfing_level_id === 1)

                    <h3>{{$score->datetime}}</h3>
                        <h4>点数</h4>
                            <p>{{$score->score}}</p>
                        <h4>波高</h4>
                            <p>{{$score->wave_height}}</p>
                        <h4>波向</h4>
                            <p>{{$score->wave_direction}}</p>
                        <h4>風向</h4>
                            <p>{{$score->wind_direction}}</p>
                        <h4>風速</h4>
                            <p>{{$score->wind_speed}}</p>
                @endif
            @elseif(request()->has('level') && request()->get('level') === '2')
                @if($score->location_id === $location->id && $score->surfing_level_id === 2)
                    <h3>{{$score->datetime}}</h3>
                        <h4>点数</h4>
                            <p>{{$score->score}}</p>
                        <h4>波高</h4>
                            <p>{{$score->wave_height}}</p>
                        <h4>波向</h4>
                            <p>{{$score->wave_direction}}</p>
                        <h4>風向</h4>
                            <p>{{$score->wind_direction}}</p>
                        <h4>風速</h4>
                            <p>{{$score->wind_speed}}</p>
                @endif
            @elseif(request()->has('level') && request()->get('level') === '3')
                @if($score->location_id === $location->id && $score->surfing_level_id === 3)
                    <h3>{{$score->datetime}}</h3>
                        <h4>点数</h4>
                            <p>{{$score->score}}</p>
                        <h4>波高</h4>
                            <p>{{$score->wave_height}}</p>
                        <h4>波向</h4>
                            <p>{{$score->wave_direction}}</p>
                        <h4>風向</h4>
                            <p>{{$score->wind_direction}}</p>
                        <h4>風速</h4>
                            <p>{{$score->wind_speed}}</p>
                @endif
            @else
                @if($score->location_id === $location->id && $score->surfing_level_id === 2)
                    <h3>{{$score->datetime}}</h3>
                        <h4>点数</h4>
                            <p>{{$score->score}}</p>
                        <h4>波高</h4>
                            <p>{{$score->wave_height}}</p>
                        <h4>波向</h4>
                            <p>{{$score->wave_direction}}</p>
                        <h4>風向</h4>
                            <p>{{$score->wind_direction}}</p>
                        <h4>風速</h4>
                            <p>{{$score->wind_speed}}</p>
                @endif
            @endif
        @endforeach
        <h2>{{$location->name}}への投稿</h2>
            @foreach($post as $post)
                @if($post->location_id === $location->id)
                    <p><b>ユーザー名｜{{$post->user->name}}</b></p>
                    <p>海に入った時間｜{{$post->surf_time}}</p>
                    <p>コメント｜{{$post->comment}}</P>
                    <p>コメントした日｜{{$post->created_at}}</P>
                @endif
            @endforeach
        </body>
    </html>
</x-app-layout>