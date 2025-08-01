@extends('layouts.app')
@section('title', 'Акт приёмки систем пылеудаления')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:900px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">

            <div class="mb-3">
                <label>Номер акта</label>
                <input type="text" name="number_acts" class="form-control" value="{{ old('number_acts', $nextActNumber ?? '') }}" required>
            </div>


            <div class="row mb-3">
                <div class="col-md-3">
                    <label>Город</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $passport->city ?? '') }}" required>
                </div>
                <div class="col-md-2">
                    <label>День</label>
                    <input type="number" name="day" class="form-control" value="{{ old('day', date('d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label>Месяц</label>
                    <input type="text" name="month" class="form-control" value="{{ old('month', date('m')) }}" required>
                </div>
                <div class="col-md-2">
                    <label>Год</label>
                    <input type="number" name="year" class="form-control" value="{{ old('year', date('Y')) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Наименование и адрес объекта</label>
                <input type="text" name="object_name" class="form-control" value="{{ old('object_name', $passport->object_name ?? '') }}" required>
            </div>

            <h5 class="mt-4">Комиссия</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Авторский надзор</label>
                    <input type="text" name="an" class="form-control" value="{{ old('an') }}">
                </div>
                <div class="col-md-4">
                    <label>Технический надзор заказчика</label>
                    <input type="text" name="tnz" class="form-control" value="{{ old('tnz') }}">
                </div>
                <div class="col-md-4">
                    <label>Подрядная организация</label>
                    <input type="text" name="po" class="form-control" value="{{ old('po') }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Субподрядная (монтажная) организация</label>
                    <input type="text" name="subpo" class="form-control" value="{{ old('subpo') }}">
                </div>
                <div class="col-md-6">
                    <label>Эксплуатирующая организация (название, лицензии, сертификаты)</label>
                    <input type="text" name="exploat" class="form-control" value="{{ old('exploat') }}">
                </div>
            </div>
            <div class="mb-3">
                <label>Уполномоченное лицо эксплуатирующей организации (фамилия, инициалы)</label>
                <input type="text" name="exploat_fio" class="form-control" value="{{ old('exploat_fio') }}">
            </div>

            <div class="mb-3">
                <label>Документы, предъявленные комиссии</label>
                <textarea name="docs" class="form-control" rows="3" placeholder="Проект и исполнительные чертежи, акты испытаний на герметичность, протоколы испытаний пылесосных устройств на эффективность пылеудаления, протоколы замера шума и др.">{{ old('docs') }}</textarea>
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
