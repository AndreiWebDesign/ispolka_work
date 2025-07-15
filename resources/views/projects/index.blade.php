@extends('layouts.app')
@section('title', 'Объекты')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Паспорта объектов</h2>
            @if(auth()->user()->role === 'подрядчик')
                <a href="{{ route('projects.create') }}" class="btn btn-success">Создать проект</a>
            @endif
        </div>

        @if($passports->isEmpty())
            <div class="alert alert-info">Нет созданных объектов.</div>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Объект</th>
                    <th>Город/Населённый пункт</th>
                    <th>Заказчик</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($passports as $passport)
                    <tr>
                        <td>{{ $passport->id }}</td>
                        <td>{{ $passport->object_name ?? '-' }}</td>
                        <td>{{ $passport->city ?? '-' }}/{{ $passport->locality ?? '-' }}</td>
                        <td>{{ $passport->customer }}</td>
                        <td>
                            <a href="{{ route('projects.show', $passport) }}" class="btn btn-primary btn-sm">Открыть</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
