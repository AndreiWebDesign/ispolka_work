@extends('layouts.app')
@section('title', 'Акт переноса отметки на репер')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:900px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">

            <h2 class="mb-4 text-center">Акт переноса отметки на репер</h2>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Город</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $passport->city ?? '') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">День</label>
                    <input type="number" name="day" class="form-control" value="{{ old('day', date('d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Месяц</label>
                    <input type="text" name="month" class="form-control" value="{{ old('month', date('m')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Год</label>
                    <input type="number" name="year" class="form-control" value="{{ old('year', date('Y')) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Номер акта</label>
                <input type="text" name="number_act" class="form-control" value="{{ old('number_act', $nextActNumber ?? '') }}" required>
            </div>

            <h5 class="mt-4 mb-2">Комиссия</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Представитель заказчика (должность, ФИО)</label>
                    <input type="text" name="pred_zk" class="form-control" value="{{ old('pred_zk') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Генподрядчик (должность, ФИО)</label>
                    <input type="text" name="pred_gp" class="form-control" value="{{ old('pred_gp') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Управление архитектуры и градостроительства (должность, ФИО)</label>
                    <input type="text" name="pred_upr" class="form-control" value="{{ old('pred_upr') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Наименование объекта (адрес)</label>
                <input type="text" name="name_object_address" class="form-control" value="{{ old('name_object_address') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Установленная отметка репера</label>
                <input type="text" name="otmetka_reper" class="form-control" value="{{ old('otmetka_reper') }}" required>
                <small class="text-muted">Например: "Отметка репера: 123.45 м"</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Нулевая отметка на репере (вспомогательная обноска)</label>
                <input type="text" name="null_otmetka" class="form-control" value="{{ old('null_otmetka') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Проверка нулевой отметки (наименование здания)</label>
                <input type="text" name="name_zdamiya" class="form-control" value="{{ old('name_zdamiya') }}" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Сохранить акт</button>
        </form>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
