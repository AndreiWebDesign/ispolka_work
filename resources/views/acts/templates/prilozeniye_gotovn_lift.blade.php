@extends('layouts.app')
@section('title', 'Акт готовности лифта к производству отделочных работ')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:900px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">
            <h2 class="mb-4 text-center">
                Акт готовности лифта к производству отделочных работ
            </h2>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label>Номер акта</label>
                    <input type="text" name="number_acts" class="form-control" value="{{ old('number_acts', $nextActNumber ?? '') }}" required>
                </div>
                <div class="col-md-2">
                    <label>День</label>
                    <input type="number" name="day" class="form-control" value="{{ old('day', date('d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label>Месяц</label>
                    <input type="text" name="month" class="form-control" value="{{ old('month', date('m')) }}" required>
                </div>
                <div class="col-md-3">
                    <label>Год</label>
                    <input type="number" name="year" class="form-control" value="{{ old('year', date('Y')) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label>Стройка и ее местонахождение</label>
                <input type="text" name="stroika_address" class="form-control" value="{{ old('stroika_address', $passport->object_name ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label>Наименование типа лифта</label>
                <input type="text" name="lift" class="form-control" value="{{ old('lift') }}" required>
            </div>
            <div class="mb-3">
                <label>Заводской номер оборудования лифта</label>
                <input type="text" name="number_lift" class="form-control" value="{{ old('number_lift') }}" required>
            </div>
            <div class="mb-3">
                <label>Примечания</label>
                <input type="text" name="prim_1" class="form-control mb-2" value="{{ old('prim_1') }}" placeholder="Оборудование обесточено">
                <input type="text" name="prim_2" class="form-control" value="{{ old('prim_2') }}" placeholder="Отделочные работы по шахте ...">
            </div>
            <h5 class="mt-4">Сдал (строительная организация, технадзор)</h5>
            <div class="row mb-3">
                <div class="col-md-5">
                    <label>ФИО</label>
                    <input type="text" name="tnp" class="form-control" value="{{ old('tnp') }}" required>
                </div>
                <div class="col-md-3">
                    <label>Должность</label>
                    <input type="text" name="tnp_dolzj" class="form-control" value="{{ old('tnp_dolzj') }}">
                </div>
            </div>
            <h5 class="mt-4">Принял (авторский надзор)</h5>
            <div class="row mb-3">
                <div class="col-md-5">
                    <label>ФИО</label>
                    <input type="text" name="an" class="form-control" value="{{ old('an') }}">
                </div>
                <div class="col-md-3">
                    <label>Должность</label>
                    <input type="text" name="an_dplj" class="form-control" value="{{ old('an_dplj') }}">
                </div>
            </div>
            <h5 class="mt-4">Принял (монтажная организация)</h5>
            <div class="row mb-3">
                <div class="col-md-5">
                    <label>ФИО</label>
                    <input type="text" name="mo" class="form-control" value="{{ old('mo') }}">
                </div>
                <div class="col-md-3">
                    <label>Должность</label>
                    <input type="text" name="mo_dolj" class="form-control" value="{{ old('mo_dolj') }}">
                </div>
            </div>
            <div class="mb-3">
                <label>Отделочные работы по шахте</label>
                <input type="text" name="otdel_raboty" class="form-control" value="{{ old('otdel_raboty') }}">
            </div>
            <div class="mb-3">
                <label>Заводской номер лифта (повторно, если нужно)</label>
                <input type="text" name="lift_number" class="form-control" value="{{ old('lift_number') }}">
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
