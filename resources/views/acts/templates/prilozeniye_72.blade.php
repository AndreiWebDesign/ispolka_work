@extends('layouts.app')
@section('title', 'Акт приёмки систем естественной вентиляции')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:900px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">

            <h2 class="mb-4 text-center">Акт приёмки системы естественной вентиляции</h2>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Номер акта</label>
                    <input type="text" name="number_acts" class="form-control" value="{{ old('number_acts', $nextActNumber ?? '') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Город</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $passport->city ?? '') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">День</label>
                    <input type="number" name="day" class="form-control" value="{{ old('day', date('d')) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Месяц</label>
                    <input type="text" name="month" class="form-control" value="{{ old('month', date('m')) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Год</label>
                    <input type="number" name="year" class="form-control" value="{{ old('year', date('Y')) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Наименование и адрес объекта</label>
                <input type="text" name="name_address" class="form-control" value="{{ old('name_address', $passport->object_name ?? '') }}" required>
            </div>

            <h5 class="mt-4">Представители</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Авторский надзор (ФИО, организация, должность)</label>
                    <input type="text" name="an" class="form-control" value="{{ old('an') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Технический надзор заказчика (ФИО, организация, должность)</label>
                    <input type="text" name="tnz" class="form-control" value="{{ old('tnz') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Подрядная организация (ФИО, организация, должность)</label>
                    <input type="text" name="po" class="form-control" value="{{ old('po') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Субподрядная (монтажная) организация (ФИО, организация, должность)</label>
                <input type="text" name="subpo" class="form-control" value="{{ old('subpo') }}">
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
