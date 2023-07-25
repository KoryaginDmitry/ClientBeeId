@extends('layouts.main')

@section('title', 'Главная страница')

@section('content')
    <a href="{{ route('auth') }}">Авторизоваться через Bee-id</a>
@endsection
