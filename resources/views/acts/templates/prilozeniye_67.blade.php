@extends('layouts.app')
@section('title', 'Акт проверки мусоропровода')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:900px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">

            <h2 class="mb-4 text-center">Акт проверки мусоропровода</h2>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Номер акта</label>
                    <input type="text" name="number_acts" class="form-control"
                           value="{{ old('number_acts', $nextActNumber ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Наименование работ</label>
                    <input type="text" name="name_rabot" class="form-control"
                           value="{{ old('name_rabot', 'устройство мусоропровода') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Наименование объекта</label>
                    <input type="text" name="name_address" class="form-control"
                           value="{{ old('name_address', $passport->object_name ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Дата составления</label>
                    <input type="date" name="date" class="form-control"
                           value="{{ old('date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Месяц</label>
                    <input type="text" name="month" class="form-control"
                           value="{{ old('month', date('m')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Год</label>
                    <input type="text" name="year" class="form-control"
                           value="{{ old('year', date('Y')) }}" required>
                </div>
            </div>

            <h5 class="mt-4">Комиссия в составе</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Представитель строительно‑монтажной организации</label>
                    <input type="text" name="cmo_1" class="form-control" value="{{ old('cmo_1') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Представитель технического надзора заказчика</label>
                    <input type="text" name="tnz_1" class="form-control" value="{{ old('tnz_1') }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">2-й представитель СМО (если есть)</label>
                    <input type="text" name="cmo_2" class="form-control" value="{{ old('cmo_2') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">2-й представитель технадзора (если есть)</label>
                    <input type="text" name="tnz_2" class="form-control" value="{{ old('tnz_2') }}">
                </div>
            </div>

            <hr>
            <div class="mb-3">
                <label class="form-label">Выполнил работы (строительно‑монтажная организация)</label>
                <input type="text" name="rabot" class="form-control" value="{{ old('rabot') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">СМО, пров. (1)</label>
                    <input type="text" name="smo_prov_1#0" class="form-control" value="{{ old('smo_prov_1#0') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">СМО, пров. (2)</label>
                    <input type="text" name="smo_prov_1#1" class="form-control" value="{{ old('smo_prov_1#1') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Проектная документация</label>
                <input type="text" name="psd_1" class="form-control" value="{{ old('psd_1') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Наименование проектной организации, № чертежей, дата</label>
                <input type="text" name="psd_2" class="form-control" value="{{ old('psd_2') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Материалы, изделия (сертификаты, документы качества)</label>
                <input type="text" name="material_1" class="form-control" value="{{ old('material_1') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Материалы, изделия (доп. сведения)</label>
                <input type="text" name="material_2" class="form-control" value="{{ old('material_2') }}">
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
