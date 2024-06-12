@extends('adminlte::page')

@section('title', 'Demo Page')

@section('content_header')
    <h1>生成予約画面（TOP）</h1>
@endsection

@section('body_data')
    id="app"
@endsection


@section('content')
    <reservation-form></reservation-form>
@endsection

@section('meta_tags')
    @vite(['resources/js/app.js'])

@endsection
