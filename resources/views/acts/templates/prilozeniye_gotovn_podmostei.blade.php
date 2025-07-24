@extends('layouts.app')
@section('title', 'Акт готовности подмостей и ограждений для монтажа лифтов')

@section('content')
<div class="container py-4 d-flex justify-content-center">
    <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:900px;">
        @csrf
        <input type="hidden" name="passport_id" value="{{ $passport->id }}">
        <input type="hidden" name="type" value="{{ request('type') }}">

        <h2 class="mb-4 text-center">Акт готовности подмостей (лесов), ограждений проемов шахты к работам по монтажу лифтового оборудования</h2>

        <div class="row mb-3">
            <div class="col-md-3">
                <label>Номер акта</label>
                <input type="text" name="number_act" class="form-control" value="{{ old('number_act', $nextActNumber ?? '') }}" required>
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
            <label>Стройка и её местонахождение</label>
            <input type="text" name="stroika_address" class="form-control" value="{{ old('stroika_address', $passport->object_name ?? '') }}" required>
        </div>
        <div class="row mb-3">
            <div class="col-md-7">
                <label>Наименование типа лифта</label>
                <input type="text" name="lift_type" class="form-control" value="{{ old('lift_type') }}" required>
            </div>
            <div class="col-md-5">
                <label>Заводской номер оборудования лифта</label>
                <input type="text" name="lift_number" class="form-control" value="{{ old('lift_number') }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label>Примечание 1</label>
            <input type="text" name="prim_1" class="form-control" value="{{ old('prim_1') }}">
        </div>
        <div class="mb-3">
            <label>Примечание 2</label>
            <input type="text" name="prim_2" class="form-control" value="{{ old('prim_2') }}">
        </div>
        <h5 class="mt-4">Подписи:</h5>
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Сдал (строительная организация/технадзор): ФИО</label>
                <input type="text" name="sdat_fio" class="form-control" value="{{ old('sdat_fio') }}" required>
            </div>
            <div class="col-md-4">
                <label>Должность</label>
                <input type="text" name="sdat_dolzh" class="form-control" value="{{ old('sdat_dolzh') }}" required>
            </div>
            <div class="col-md-4">
                <label>Дата</label>
                <input type="text" name="sdat_date" class="form-control" value="{{ old('sdat_date') }}">
            </div>
        </div>
        <div class="mb-3">
            <label>Личная подпись</label>
            <input type="text" name="sdat_sign" class="form-control" value="{{ old('sdat_sign') }}">
        </div>
        <div class="mb-3">
            <label>Расшифровка подписи</label>
            <input type="text" name="sdat_decipher" class="form-control" value="{{ old('sdat_decipher') }}">
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Принял (авторский надзор): ФИО</label>
                <input type="text" name="prinyal_an_fio" class="form-control" value="{{ old('prinyal_an_fio') }}">
            </div>
            <div class="col-md-4">
                <label>Должность</label>
                <input type="text" name="prinyal_an_dolzh" class="form-control" value="{{ old('prinyal_an_dolzh') }}">
            </div>
            <div class="col-md-4">
                <label>Дата</label>
                <input type="text" name="prinyal_an_date" class="form-control" value="{{ old('prinyal_an_date') }}">
            </div>
        </div>
        <div class="mb-3">
            <label>Личная подпись</label>
            <input type="text" name="prinyal_an_sign" class="form-control" value="{{ old('prinyal_an_sign') }}">
        </div>
        <div class="mb-3">
            <label>Расшифровка подписи</label>
            <input type="text" name="prinyal_an_decipher" class="form-control" value="{{ old('prinyal_an_decipher') }}">
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Принял (монтажная организация): ФИО</label>
                <input type="text" name="prinyal_mont_fio" class="form-control" value="{{ old('prinyal_mont_fio') }}">
            </div>
            <div class="col-md-4">
                <label>Должность</label>
                <input type="text" name="prinyal_mont_dolzh" class="form-control" value="{{ old('prinyal_mont_dolzh') }}">
            </div>
            <div class="col-md-4">
                <label>Дата</label>
                <input type="text" name="prinyal_mont_date" class="form-control" value="{{ old('prinyal_mont_date') }}">
            </div>
        </div>
        <div class="mb-3">
            <label>Личная подпись</label>
            <input type="text" name="prinyal_mont_sign" class="form-control" value="{{ old('prinyal_mont_sign') }}">
        </div>
        <div class="mb-3">
            <label>Расшифровка подписи</label>
            <input type="text" name="prinyal_mont_decipher" class="form-control" value="{{ old('prinyal_mont_decipher') }}">
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
