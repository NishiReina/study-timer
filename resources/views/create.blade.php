<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link href="{{ secure_asset('/css/reset.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('/css/common.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('/css/create.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('/css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/create.css') }}" rel="stylesheet"> -->
</head>
<body>
@extends('layouts.common')
@section('content')

<div class="create">
    <div class="create__header">
        <h1>今日の日記</h1>
    </div>
    <form action="/create" method="POST" class="create__form">
    @csrf
    <div class="create__ttl">
        <div class="create__ttl-input-bg">
            @error('title')
                <p class="validation">{{$message}}</p>
            @enderror
            <input class="create__ttl-input" type="text" name="title" placeholder="タイトル">
        </div>
        <div class="create__ttl-time">
            <p class="create__ttl-time-text">今日の学習時間:</p>
            <input name="time" type="text" value="{{$data}}" class="create__ttl-time--bold" readonly>
        </div>
    </div>
    <div class="create__textarea">
        @error('content')
        <p class="validation">{{$message}}</p>
        @enderror
        <textarea class="create__textarea-item" name="content" id="" cols="120" rows="30" placeholder="本文"></textarea>
    </div>
    <div class="create-btn">
        <input type="submit" value="今日の勉強を終了" class="create-btn__a btn">
    </div>
    </form>
    <div class="back-btn">
        <a href="/" class="back-btn__a btn">戻る</a>
    </div>
</div>

@endsection
</body>
</html>