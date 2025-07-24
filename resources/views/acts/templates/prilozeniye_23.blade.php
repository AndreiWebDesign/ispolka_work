@extends('layouts.app')
@section('title', 'Акт посадки здания')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width: 900px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">

            <h2 class="mb-4 text-center">Акт посадки здания</h2>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Номер акта</label>
                    <input type="text" name="number_acts" class="form-control" value="{{ old('number_acts', $nextActNumber ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">День</label>
                    <input type="number" name="day" class="form-control" value="{{ old('day', date('d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Месяц</label>
                    <input type="text" name="month" class="form-control" value="{{ old('month', date('m')) }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Год</label>
                    <input type="number" name="year" class="form-control" value="{{ old('year', date('Y')) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Город</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $passport->city ?? '') }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Наименование объекта</label>
                <input type="text" name="name_object" class="form-control" value="{{ old('name_object', $passport->object_name ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Представитель заказчика (должность, ФИО)</label>
                <input type="text" name="pred_zakaz" class="form-control" value="{{ old('pred_zakaz') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Генподрядчик (должность, ФИО)</label>
                <input type="text" name="pred_gp" class="form-control" value="{{ old('pred_gp') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Представитель управления архитектуры/градостроительства (должность, ФИО)</label>
                <input type="text" name="pred_tn" class="form-control" value="{{ old('pred_tn') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">На основании решения</label>
                <textarea name="geodez_docs" class="form-control" rows="2">{{ old('geodez_docs') }}</textarea>
                <small class="text-muted">Наименование органа, дата (например: Решение администрации города от ...)</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Дополнительная техническая информация (например, рабочие чертежи, задание, результат геодезиста)</label>
                <textarea name="tech_docs_1" class="form-control" rows="2">{{ old('tech_docs_1') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Оси закреплены, привязаны и переданы следующим лицам</label>
                <textarea name="tech_docs_2" class="form-control" rows="2">{{ old('tech_docs_2') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Приложения (чертежи, ведомости)</label>
                <textarea name="prilojenie_1" class="form-control" rows="2">{{ old('prilojenie_1') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Другие приложения</label>
                <textarea name="prilojenie_2" class="form-control" rows="2">{{ old('prilojenie_2') }}</textarea>
            </div>

            <hr>
            <h5 class="mt-4">Подписи</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Геодезист (сдал)</label>
                    <input type="text" name="sign_geodezist" class="form-control" value="{{ old('sign_geodezist') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Принял заказчик</label>
                    <input type="text" name="sign_zakaz" class="form-control" value="{{ old('sign_zakaz') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Принял подрядчик</label>
                    <input type="text" name="sign_gp" class="form-control" value="{{ old('sign_gp') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Сохранить акт</button>
        </form>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
