@extends('layouts.app')
@section('title', 'Регистрация')

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center flex-grow-1">
        <form method="POST" action="{{ route('register.post') }}" class="bg-white p-4 rounded shadow w-100" style="max-width: 400px;">
            @csrf
            <h2 class="mb-4 text-center">Регистрация</h2>

            {{-- Вывод ошибок валидации --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Вывод flash-сообщения об успехе --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Имя" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Пароль" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Подтвердите пароль" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Зарегистрироваться</button>
            <div class="mt-3 text-center">
                <a href="{{ route('login') }}">Уже есть аккаунт? Войти</a>
            </div>
        </form>
    </div>
@endsection
