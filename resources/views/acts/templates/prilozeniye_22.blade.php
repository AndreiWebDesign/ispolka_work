@extends('layouts.app')
@section('title', 'Создать акт приёмки-передачи результатов геодезических работ')

@section('content')
<div class="container py-4 d-flex justify-content-center">
    <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width: 900px;">
        @csrf
        <input type="hidden" name="passport_id" value="{{ $passport->id }}">
        <input type="hidden" name="type" value="{{ request('type') }}">
        <h2 class="mb-4 text-center">Акт приёмки-передачи результатов геодезических работ</h2>

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
                <label class="form-label">Город (место составления)</label>
                <input type="text" name="city" class="form-control" value="{{ old('city', $passport->city ?? '') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Наименование объекта строительства</label>
            <input type="text" name="name_object" class="form-control" value="{{ old('name_object', $passport->object_name ?? '') }}" required>
        </div>

        <hr>
        <h5 class="mt-4">Комиссия в составе</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Передающая сторона (ФИО, должность)</label>
                <input type="text" name="pred_sm_pered_fio" class="form-control" value="{{ old('pred_sm_pered_fio') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Принимающая сторона (ФИО, должность)</label>
                <input type="text" name="pred_sm_prinim_fio" class="form-control" value="{{ old('pred_sm_prinim_fio') }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Передающая сторона (организация)</label>
                <input type="text" name="pred_sm_pered_comp" class="form-control" value="{{ old('pred_sm_pered_comp') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Принимающая сторона (организация)</label>
                <input type="text" name="pred_sm_prinim_comp" class="form-control" value="{{ old('pred_sm_prinim_comp') }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Наименование объекта (для передачи и приёма)</label>
            <input type="text" name="name_object_1" class="form-control" value="{{ old('name_object_1') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Наименование объекта (отдельные части/детализация)</label>
            <input type="text" name="name_object_2" class="form-control" value="{{ old('name_object_2') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Перечень приложений (чертежи, схемы, ведомости и т. д.)</label>
            <textarea name="prilojeniya" class="form-control" rows="2">{{ old('prilojeniya') }}</textarea>
        </div>

        <hr>
        <h5 class="mt-4">Подписи</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Передающая сторона (ФИО для подписи)</label>
                <input type="text" name="pred_sm_pered" class="form-control" value="{{ old('pred_sm_pered') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Принимающая сторона (ФИО для подписи)</label>
                <input type="text" name="pred_sm_prinim" class="form-control" value="{{ old('pred_sm_prinim') }}" required>
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
