<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link href="{{ asset('/css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/index.css') }}" rel="stylesheet">
    
</head>
<body>
    @extends('layouts.common')
    @section('content')
        <div class="time">
            <div class="time__list">
                <div class="time__list-item">
                    <div class="time-list__card">
                        <p class="time-list__card__ttl">今月の学習時間</p>
                        <div class="time-list__card-time">
                            <p>{{$sumMonthTime}}</p>
                        </div>
                        <p class="time-list__card-comment">先月より{{$compareMonth}}</p>
                    </div>
                </div>

                <div class="time__list-item">
                    <div class="time-list__card">
                        <p class="time-list__card__ttl">今日の勉強時間</p>
                        <div class="time-list__card-time">
                        <form class="time-list__form" action="/" method="post">
                        @csrf
                            <!-- <p id="time">00:00:00</p> -->
                            <input type="text" id="time" name="date" value="{{$date}}" readonly> 
                        </div>
                        <div class="time-list__card-btn">
                            <div class="btn">
                                <button type="button" id="startTimer" class="control-btn">START</button>
                            </div>
                            <div class="btn">
                                <button type="submit" id="stopTimer" class="control-btn">STOP</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="time__list-item">
                    <div class="time-list__card">
                        <p class="time-list__card__ttl">今週の勉強時間</p>
                        <div class="time-list__card-time">
                            <p>{{$sumWeekTime}}</p>
                        </div>
                        <p class="time-list__card-comment">先週より{{$compareWeek}}</p>
                    </div>
                </div>
                <div class="time__list-best">
                    <div class="time-list__best-item">
                        <p class="time-list__best__ttl">最も勉強した日</p>
                        <div class="time-list__best-num">
                            <p class="time-list__best-text">{{$bestD[0]}}</p>
                            <p class="time-list__best-text">{{$bestD[1]}}</p>
                        </div>
                    </div>
                    <div class="time-list__best-item">
                        <p class="time-list__best__ttl">最も勉強した月</p>
                        <div class="time-list__best-num">
                            <p class="time-list__best-text">{{$bestM[0] ?? null}}</p>{{-- null許容--}}
                            <p class="time-list__best-text">{{$bestM[1] ?? null}}</p>
                        </div>
                    </div>
                    <div class="btn-diary">
                        <div class="btn">
                            <a href="/add">日記を書く</a>
                        </div>
                        <div class="btn">
                            <a href="{{route('list', ['month' => $month ])}}">勉強日記</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <script src="{{ asset('/js/main.js') }}"></script>
</body>
</html>