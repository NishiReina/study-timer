<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List</title>
    <link href="{{ asset('/css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/list.css') }}" rel="stylesheet">
</head>
<style>
    svg.w-5.h-5 {  /*paginateメソッドの矢印の大きさ調整のために追加*/
    width: 30px;
    height: 30px;
    }
</style>
<body>
    @extends('layouts.common')
    @section('content')
    <div class="list">
        <div class="list__ttl">
            <h1>{{$month}}日記一覧</h1>
        </div>
        <div class="list__wrap">
            <div class="list__diary-wrap">
                <div class="list__diary-item">
                    <p class="list__diary-ttl">
                        {{$month}}の日記
                    </p>
                    <div class="list__diary-table">
                        <div class="list__diary-th">
                            <p>日付</p>
                            <p>タイトル</p>
                            <p>時間</p>
                        </div>
                        <div class="list__diary-table-item">
                        <table>
                            @foreach ($diaries as $diary)
                            <tr>
                                <td>{{$diary->created_at->format('m月d日')}}</td>
                                <td><a href="{{ route('detail', ['id' => $diary->id]) }}">{{$diary->title}}</a></td>
                                <td>{{$diary->time}}</td>              
                            </tr>
                            </a>
                            @endforeach
                        </table>
                    </div>  
                    </div>
                </div>
            </div>
            <div class="list__wrap-item">
                <div class="list__wrap-item-box">
                    <p class="list__wrap-item__ttl">{{$month}}月の合計勉強時間</p>
                    <div class="list__wrap-item-num">
                        <p>{{$sumMonthTime}}</p>
                    </div>
                </div>
                <div class="list__wrap-item-box">
                    <p class="list__wrap-item__ttl">1週あたりの平均勉強時間</p>
                    <div class="list__wrap-item-num">
                        <p>{{$avgWeekTime}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="list-btn__wrap">
            <div class="list-btn">
                <a href="/show" class="list-btn__a btn">日記一覧</a>
            </div>
            <div class="list-btn">
                <a href="/" class="list-btn__a btn">ホーム</a>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="{{ asset('/js/main.js') }}"></script>
</body>

</html>
