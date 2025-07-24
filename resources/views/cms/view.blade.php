@extends('layouts.app')

@section('title', 'Результаты проверки CMS')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Результаты проверки CMS</h3>

        @foreach ($signatures as $index => $sig)
            <h5>Подпись №{{ $index + 1 }}</h5>
            <table class="table table-bordered mb-2">
                <tr><th>Результат проверки сертификата</th><td>{{ $sig['status']['cert'] }}</td></tr>
                <tr><th>Результат проверки TSP</th><td>{{ $sig['status']['tsp'] }}</td></tr>
                <tr><th>Результат проверки подписи</th><td>{{ $sig['status']['sign'] }}</td></tr>
                <tr><th>ИИН</th><td>{{ $sig['iin'] }}</td></tr>
                <tr><th>ФИО</th><td>{{ $sig['fio'] }}</td></tr>
                <tr><th>Серийный номер сертификата</th><td>{{ $sig['serial'] }}</td></tr>
                <tr><th>Срок действия сертификата</th><td>{{ $sig['validity'] }}</td></tr>
                <tr><th>Шаблон сертификата</th><td>{{ $sig['template'] }}</td></tr>
                <tr><th>Дата подписания</th><td>{{ $sig['signingDate'] }}</td></tr>
            </table>

            @if (isset($sig['cms_path']))
                <a href="{{ asset('storage/' . $sig['cms_path']) }}" class="btn btn-sm btn-primary mb-4" download>
                    Скачать CMS-файл
                </a>
            @endif
        @endforeach

        <a href="{{ url()->previous() }}" class="btn btn-secondary">Назад</a>
    </div>
@endsection
