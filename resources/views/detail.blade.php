<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>detail</title>
    <link href="{{ secure_asset('/css/reset.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('/css/common.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('/css/detail.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('/css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/detail.css') }}" rel="stylesheet"> -->
</head>
<body>
@extends('layouts.common')
@section('content')

<div class="detail">
    <div class="detail__ttl">
        <h1 class="detail__ttl-ttl">{{$diary->title}}</h1>
        <p class="detail__ttl-day">{{$diary->created_at->format('Y年m月d日')}}</p>
    </div>
    <div class="detail__title">
        <div class="detail__title-time">
            <p>勉強時間: <span class="detail__title-time--bold">{{$diary->time}}</span></p>
        </div>
    </div>
    <div class="detail-textarea" name="" id="" cols="120" rows="30" placeholder="本文">
        <p>{{$diary->content}}</p>
    </div>
    <div class="detail-btn__wrap">
        <div class="detail-btn">
            <a href="{{ route('edit', ['id' => $diary->id]) }}" class="detail-btn__a btn">日記の編集</a>
        </div>
        <div class="detail-btn">
            <form action="{{ route('delete', ['id' => $diary->id]) }}" method="POST" class="detail-btn__form">
                @csrf
                <input type="submit" class="detail-btn__a btn detail-btn__input" value="日記の削除">
            </form>
        </div>
        <div class="detail-btn">
            <a href="{{route('list', ['month' => $diary->created_at->format('Y-m')])}}" class="detail-btn__a detail-btn__a--size btn">{{$diary->created_at->format('Y年m月')}}の日記一覧</a>
        </div>
        <div class="detail-btn">
            <a href="/" class="detail-btn__a btn">ホーム</a>
        </div>
    </div>
</div>

@endsection
</body>
</html>