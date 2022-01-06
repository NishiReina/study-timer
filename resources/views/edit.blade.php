<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link href="{{ asset('/css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/edit.css') }}" rel="stylesheet">
</head>
<body>
@extends('layouts.common')
@section('content')

<div class="edit">
    <div class="edit__header">
        <h1>日記編集</h1>
    </div>
    <form class="edit__form" action="{{ route('update', ['id' => $diary->id]) }}" method="POST">
    @csrf
    <div class="edit__ttl">
        <div class="edit__ttl-input">
            @error('title')
                <p class="validation">{{$message}}</p>
            @enderror
            <input class="create__ttl-input" type="text" name="title" placeholder="タイトル">
        </div>
        <div class="edit__ttl-time">
            <p>今日の学習時間: <span class="edit__ttl-time--bold">{{$diary->time}}</span></p>
        </div>
    </div>
    <div class="edit__textarea">
        @error('content')
        <p class="validation">{{$message}}</p>
        @enderror
        <textarea class="edit__textarea-item" class="create__textarea-item" name="content" id="" cols="120" rows="30" placeholder="本文"></textarea>
    </div>
    <div class="edit-btn">
        <input type="submit" class="edit-btn__a btn" value="保存">
    </div>
    </form>
</div>

@endsection
</body>
</html>