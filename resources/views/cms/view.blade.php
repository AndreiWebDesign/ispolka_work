@extends('layouts.app')

@section('title', 'Результат проверки CMS')

@section('content')
    <div class="container mt-4">
        <h3>Результат проверки CMS</h3>

        <table class="table table-bordered">
            <tr><th>Результат проверки сертификата</th><td>{{ $status['cert'] }}</td></tr>
            <tr><th>Результат проверки TSP</th><td>{{ $status['tsp'] }}</td></tr>
            <tr><th>Результат проверки подписи</th><td>{{ $status['sign'] }}</td></tr>
            <tr><th>ИИН</th><td>{{ $iin }}</td></tr>
            <tr><th>ФИО</th><td>{{ $fio }}</td></tr>
            <tr><th>Серийный номер сертификата</th><td>{{ $serial }}</td></tr>
            <tr><th>Срок действия сертификата</th><td>{{ $validity }}</td></tr>
            <tr><th>Шаблон сертификата</th><td>{{ $template }}</td></tr>
            <tr><th>Дата подписания</th><td>{{ $signingDate }}</td></tr>
        </table>

        <a href="{{ url()->previous() }}" class="btn btn-secondary">Назад</a>
    </div>
@endsection
