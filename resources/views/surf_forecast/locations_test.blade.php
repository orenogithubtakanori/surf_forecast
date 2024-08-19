@extends('layouts.common')
@section('content')
    <main>
        <div class="ajust"></div>
        <h1>{{$location->name}}</h1>
        <div class="shoreline_direction">
        <p>{{$location->name}}の海岸の向き</p>
            @foreach($shoreline_direction as $shoreline_direction)
                @if($shoreline_direction->id === $location->shoreline_direction_id)
                    <p>{{$shoreline_direction->direction}} </p>
                    <p sytle="transform: rotate({{$shoreline_direction->arrow_deg}}deg);">↑</p>
                @endif
            @endforeach
        </div>
        <h2>予報データ</h2>
        <div class="over-table-box">
            <ul class = "over-table-box-inside">
                <li>
                    <form method="GET"　action="{{route('your_route_name',['locationId' => $location->id])}}">
                        <input class="date" type="date" id="date" name="surf_date" value="{{$surf_date}}">
                        <button type="submit">検索</button>
                    </form>
                </li>
                <li class="sunriseset">日出｜xx:xx</li>
                <li class="sunriseset">日入｜xx:xx</li>
            </ul>
        </div>
        <table border="1">
            <thead>
                <tr>
                    <th class = "t-column1">datetime</th>
                    <th class = "t-column2">波高</th>
                    <th class = "t-column3">波向</th>
                    <th class = "t-column4">風速</th>
                    <th class = "t-column5">風向</th>
                </tr>
            </thead>
            <tbody>
            @foreach($score as $index => $s)
                @if($s->location_id === $location->id)
                    <tr>
                        <td class = "t-column1">{{$s->datetime}}</td>
                        <td class = "t-column2">{{$s->wave_height}}</td>
                        <td class = "t-column3">
                            {{$s->wave_direction}}
                            @if(isset($wave_arrow_degs[$index]))
                                <div style="transform: rotate({{$wave_arrow_degs[$index]}}deg);">↓</div>
                            @endif
                        </td>
                        <td class = "t-column4">{{$s->wind_speed}}</td>
                        <td class="t-column5">
                            {{$s->wind_direction}}
                            @if(isset($wind_arrow_degs[$index]))
                                <div style="transform: rotate({{$wind_arrow_degs[$index]}}deg);">↓</div>
                            @endif
                        </td>
                    </tr>    
                @endif
            @endforeach
            </tbody>
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
    width: 100%;
    padding: 10px;
    text-align: left;
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
    width: 636px;
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
th,td,tr{
    text-align:center;
}
table{
    position: relative;
    left: 85px;
    margin: 10px;
}
thead,tbody{
    display: block;
}
tbody{
    overflow-x:hidden;
    overflow-y:scroll;
    height:500px;
}
.t-column1{
    width:200px;
}
.t-column2{
    width:100px;
}
.t-column3{
    width:100px;
    text-align:center;
    display:flex;  
    justify-content: center; /* Flexboxで内容を中央寄せ */
    align-items: center;
}
.t-column4{
    width:100px;
}
.t-column5{
    width:100px;
    text-align:center;
    display:flex;    
    justify-content: center; /* Flexboxで内容を中央寄せ */
    align-items: center;
}
.shoreline_direction{
    display: flex;
    flex-wrap: wrap; /* 要素が多い場合に折り返す */
    gap: 10px;
    margin-left: 5px;
    padding: 5px 10px;
    /*background-color: #f0f0f0; */
    /*border: 1px solid #ddd; */
    /*border-radius: 4px; */
    position: relative;
    left: 75px;
    margin: 10px;
}
</style>