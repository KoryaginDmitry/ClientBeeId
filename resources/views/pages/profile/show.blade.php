@extends('layouts.main')

@section('title', 'Профиль')

@section('content')
    <div>
        <p>{{ $user->name }}</p>
        <p>{{ $user->post }}</p>
        <p>{{ $user->email }}</p>
        <p>{{ $user->phone }}</p>
        <a href="{{ route('profile.edit') }}">Редактировать профиль</a>
    </div>

    <a href="{{ route('logout') }}">Выйти</a>
@endsection
