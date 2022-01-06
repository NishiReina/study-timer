<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>show</title>
    <link href="{{ asset('/css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/show.css') }}" rel="stylesheet">
</head>
<body>
@extends('layouts.common')
@section('content')
<div class="show">
    <div class="show__ttl">
        <h1>日記一覧</h1>
    </div>
    <div class="show__diary-wrap">
        <div class="show__diary-item">
            <p class="show__diary-ttl">
                今週の日記
            </p>
            <div class="show__diary-table">
                <div class="show__diary-th">
                    <p>日付</p>
                    <p>タイトル</p>
                </div>
                <table>
                    @foreach($diaries as $diary)
                    <tr>
                        <td><a href="{{ route('detail', ['id' => $diary->id]) }}">{{$diary->created_at->format('Y年m月d日')}}</a></td>
                        <td>{{$diary->title}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="show__diary-item">
            <p class="show__diary-ttl">
                これまでの日記
            </p>
            <div class="show__diary-table all">
                <div class="show__diary-table-item">
                <table>
                    <tbody>
                    @if ($lists[0] != null)
                    @foreach($lists as $list)
                    <tr>
                        <td><a href="{{ route('list', ['month' => $list->format('Y-m')]) }}">{{$list->format('Y年m月')}}の日記一覧</a></td>
                    </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <div class="show-btn">
        <a href="/" class="show-btn__a btn">ホーム</a>
    </div>
</div>
@endsection
</body>
</html>