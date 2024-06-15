@extends('layouts.common')
@section('content')
    <main>
        <div class="ajust"></div>
        <h1>{{$location->name}}</h1>
        <h2>予報データ</h2>
        <div class="over-table-box">
            <ul class = "over-table-box-inside">
                <li><input class="date" type="date" name="surf_time"></li>
                <li class="sunriseset">日出｜xx:xx</li>
                <li class="sunriseset">日入｜xx:xx</li>
            </ul>
        </div>
        <table border="1">
            <tr>
                <th>datetime</th>
                <th>波高</th>
                <th>波向</th>
                <th>風向</th>
                <th>風速</th>
            </tr>
            @foreach($score as $score)
                @if($score->location_id === $location->id)
                    <tr>
                        <td>{{$score->datetime}}</td>
                        <td>{{$score->wave_height}}</td>
                        <td>{{$score->wave_direction}}</td>
                        <td>{{$score->wind_speed}}</td>
                        <td>{{$score->wind_direction}}</td>
                    </tr>    
                @endif
            @endforeach
        </table>
        <h2>{{$location->name}}への投稿</h2>
            @foreach($post as $post)
                @if($post->location_id === $location->id)
                <li>
                    <p><b>ユーザー名｜{{$post->user->name}}</b></p>
                    <p>海に入った時間｜{{$post->surf_time}}</p>
                    <p>コメント｜{{$post->comment}}</P>
                    <p>コメントした日｜{{$post->created_at}}</P>
                </li>
                @endif
            @endforeach
    </main>
@endsection

<style>
.ajust{
    height:100px;
}
h1{
    position: relative;
    left: 25px;
    width: 100px;
    padding: 10px;
    text-align: center;
}
h2{
    position: relative;
    left: 75px;
    margin: 10px;
}
.over-table-box{
    position: relative;
    left: 85px;
    height: 50px;
    width: 400px;
    background-color: gray;
    margin: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.sunriseset{
    background-color: #FFFFFF;
    padding: 0px 5px;
}
ul{
    padding-inline-start: 0px;
}
.over-table-box-inside li{
    height: 30px;
    position: relative;
    list-style-type: none;
    display: inline-block;
    margin: 5px 10px;
    align-items: center;
}
table{
    position: relative;
    left: 85px;
    margin: 10px;
}
</style>