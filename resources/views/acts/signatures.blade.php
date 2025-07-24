@extends('layouts.app')
@section('title', "Акт №{$model->act_number} ({$type})")

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Информация об акте №{{ $model->act_number }}</h2>

        <h4>Подписи (из БД)</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Роль</th>
                <th>ФИО</th>
                <th>Статус</th>
                <th>Дата подписания</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($signaturesFromDb as $sig)
                <tr>
                    <td>{{ $sig->role }}</td>
                    <td>{{ $sig->user->name ?? '—' }}</td>
                    <td>{{ $sig->status }}</td>
                    <td>{{ $sig->signed_at ? \Carbon\Carbon::parse($sig->signed_at)->format('d.m.Y H:i') : '—' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h4 class="mt-5">Детали из CMS-файлов</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ФИО</th>
                <th>ИИН</th>
                <th>Серийный номер</th>
                <th>Срок действия</th>
                <th>Дата подписания</th>
                <th>CMS</th> <!-- Новая колонка -->
            </tr>
            </thead>
            <tbody>
            @forelse ($cmsSignatures as $cms)
                <tr>
                    <td>{{ $cms['fio'] }}</td>
                    <td>{{ $cms['iin'] }}</td>
                    <td>{{ $cms['serial'] }}</td>
                    <td>{{ $cms['validity'] }}</td>
                    <td>{{ $cms['signingDate'] }}</td>
                    <td>
                        @if (!empty($cms['cms_path']))
                            <a href="{{ $cms['cms_path'] }}" class="btn btn-sm btn-outline-primary">Скачать CMS</a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Нет валидных CMS-файлов</td>
                </tr>
            @endforelse
            </tbody>
        </table>


    </div>

    <a href="{{ url()->previous() }}" class="btn btn-secondary">Назад</a>
@endsection
