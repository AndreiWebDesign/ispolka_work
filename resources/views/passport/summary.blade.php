@extends('layouts.app')
@section('title', 'Шаг 4 — Завершение')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">🎉 Проект успешно создан!</h2>
            <p class="lead">Вот информация, которую вы указали</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-success text-white">
                        Информация об объекте
                    </div>
                    <div class="card-body">
                        <p><strong>Объект:</strong> {{ $passport->object_name }}</p>
                        <p><strong>Заказчик:</strong> {{ $passport->customer }}</p>
                        <p><strong>Подрядчик:</strong> {{ $passport->contractor }}</p>
                        <p><strong>Населённый пункт:</strong> {{ $passport->locality }}</p>
                        <p><strong>Город:</strong> {{ $passport->city }}</p>
                        <p><strong>Номер ПСД:</strong> {{ $passport->psd_number }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-info text-white">
                        Выбранные акты
                    </div>
                    <div class="card-body">
                        @if($selectedActs->isEmpty())
                            <p class="text-muted">Акты не выбраны.</p>
                        @else
                            <ul class="list-group">
                                @foreach($selectedActs as $key => $value)
                                    <li class="list-group-item">
                                        {{ config("act_templates.$key.label") ?? config("hidden_work_headings.$key.text") ?? $key }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('projects.index') }}" class="btn btn-outline-primary px-4">
                Перейти к списку проектов
            </a>
        </div>
    </div>
@endsection
