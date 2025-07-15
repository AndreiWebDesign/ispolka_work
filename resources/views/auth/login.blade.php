@extends('layouts.app')
@section('title', 'Вход')

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center flex-grow-1">
        <form method="POST" action="{{ route('login') }}" class="bg-white p-4 rounded shadow w-100" style="max-width: 400px;">
            @csrf
            <h2 class="mb-4 text-center">Вход</h2>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
            </div>
            <div class="mb-4">
                <input type="password" name="password" class="form-control" placeholder="Пароль" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Войти</button>
            <div class="mt-3 text-center">
                <a href="{{ route('register') }}">Нет аккаунта? Зарегистрироваться</a>
            </div>
        </form>
    </div>
@endsection
