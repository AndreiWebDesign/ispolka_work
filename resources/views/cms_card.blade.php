@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3>Информация из CMS-файла</h3>
        <ul class="list-group mb-3">
            <li class="list-group-item"><strong>ФИО:</strong> {{ $fio }}</li>
            <li class="list-group-item"><strong>ИИН:</strong> {{ $iin }}</li>
            <li class="list-group-item"><strong>Дата подписи:</strong> {{ $signing_time }}</li>
        </ul>

        <h5>Сырой вывод OpenSSL:</h5>
        <pre style="background: #f8f9fa; padding: 1rem;">{{ $raw }}</pre>
    </div>
@endsection
