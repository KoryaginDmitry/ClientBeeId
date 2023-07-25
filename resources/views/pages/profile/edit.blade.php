@extends('layouts.main')

@section('title', 'Редактирование профиля')

@section('content')
    <div>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <input type="text" name="name" value="{{ $user->name }}" placeholder="Введи имя">
            <input type="text" name="post" value="{{ $user->post }}" placeholder="Введи должность">
            <input type="email" name="email" value="{{ $user->email }}" placeholder="Введи email">
            <input type="text" name="phone" value="{{ $user->phone }}" placeholder="Введи номер телефона">
            <input type="submit" value="Изменить">
        </form>
    </div>
@endsection
