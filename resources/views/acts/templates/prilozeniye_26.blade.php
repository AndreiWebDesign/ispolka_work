@extends('layouts.app')
@section('title', 'Акт геодезической проверки положения конструктивного элемента мостового сооружения')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:900px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">

            <h2 class="mb-4 text-center">
                Акт геодезической проверки положения конструктивного элемента мостового сооружения в плане и профиле
            </h2>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Номер акта</label>
                    <input type="text" name="number_acts" class="form-control" value="{{ old('number_acts', $nextActNumber ?? '') }}" required>
                </div>
                <div class="col-md-3">
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
                <label class="form-label">Главный инженер (председатель комиссии, ФИО)</label>
                <input type="text" name="glav_injener" class="form-control" value="{{ old('glav_injener') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Члены комиссии (должности, ФИО)</label>
                <textarea name="komisiay" class="form-control" rows="2" required>{{ old('komisiay') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Геодезическая проверка проведена (описание работ)</label>
                <textarea name="geodez_prov" class="form-control" rows="2" required>{{ old('geodez_prov') }}</textarea>
                <small class="text-muted">Например: проверка положения опоры/балки, описание конструктивного элемента</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Исходный репер №</label>
                    <input type="text" name="number_rep" class="form-control" value="{{ old('number_rep') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Отметка репера</label>
                    <input type="text" name="otmetka_rep" class="form-control" value="{{ old('otmetka_rep') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Заключение комиссии</label>
                <textarea name="zakl" class="form-control" rows="3" required>{{ old('zakl') }}</textarea>
                <small class="text-muted">Укажите отклонения, соответствие допускам, возможность дальнейшего производства работ</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Применяемый норматив (СНиП)</label>
                <input type="text" name="snip" class="form-control" value="{{ old('snip') }}" required>
                <small class="text-muted">Например: СНиП II-23-81*</small>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Сохранить акт</button>
        </form>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
