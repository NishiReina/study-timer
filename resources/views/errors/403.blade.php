@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
<h3>投稿は1日1回のみです。</h3>
<a href="/add">戻る</a>
@section('message', __($exception->getMessage() ?: 'Forbidden'))