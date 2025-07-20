@extends('layouts.app')

@section('title', 'Результат проверки CMS')

@section('content')
    <div class="container mt-4">
        <h3>Результат проверки CMS</h3>



        <a href="{{ url()->previous() }}" class="btn btn-secondary">Назад</a>
    </div>
@endsection
