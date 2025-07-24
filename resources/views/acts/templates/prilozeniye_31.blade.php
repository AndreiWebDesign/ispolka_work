@extends('layouts.app')
@section('title', 'Акт об изготовлении контрольных образцов бетона')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:900px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">

            <h2 class="mb-4 text-center">Акт об изготовлении контрольных образцов бетона</h2>

            <div class="row mb-3">
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
                <div class="col-md-6">
                    <label class="form-label">Номер акта</label>
                    <input type="text" name="number_acts" class="form-control" value="{{ old('number_acts', $nextActNumber ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">День изготовления</label>
                    <input type="number" name="day_izgot" class="form-control" value="{{ old('day_izgot', date('d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Месяц изготовления</label>
                    <input type="text" name="month_izgot" class="form-control" value="{{ old('month_izgot', date('m')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Серия</label>
                    <input type="text" name="seria" class="form-control" value="{{ old('seria') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Номер образцов</label>
                <input type="text" name="number_obr" class="form-control" value="{{ old('number_obr') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Маркировка</label>
                <input type="text" name="markirovka" class="form-control" value="{{ old('markirovka') }}">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Количество образцов (шт.)</label>
                    <input type="number" name="kolvo" class="form-control" value="{{ old('kolvo') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Размеры образцов (см)</label>
                    <input type="text" name="razmer" class="form-control" value="{{ old('razmer') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Наименование конструктивного элемента</label>
                <input type="text" name="name_constr" class="form-control" value="{{ old('name_constr') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">№ карточки подбора состава бетона</label>
                <input type="text" name="number_card" class="form-control" value="{{ old('number_card') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Класс бетона по прочности на сжатие</label>
                <input type="text" name="class_beton" class="form-control" value="{{ old('class_beton') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Водоцементное отношение В/Ц</label>
                <input type="text" name="vodosement" class="form-control" value="{{ old('vodosement') }}">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Осадка конуса (см)</label>
                    <input type="text" name="osadka" class="form-control" value="{{ old('osadka') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Жёсткость (сек)</label>
                    <input type="text" name="sek" class="form-control" value="{{ old('sek') }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Температура воздуха (°С)</label>
                    <input type="text" name="temp" class="form-control" value="{{ old('temp') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Бетономешалка системы</label>
                    <input type="text" name="betonomesh" class="form-control" value="{{ old('betonomesh') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Формы (чугунные/стальные)</label>
                <input type="text" name="forms" class="form-control" value="{{ old('forms') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Сроки распалубки образцов</label>
                <input type="text" name="srok_raspalubki" class="form-control" value="{{ old('srok_raspalubki') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Условия твердения образцов</label>
                <input type="text" name="uslovia" class="form-control" value="{{ old('uslovia') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Запись в журнале испытаний №</label>
                <input type="text" name="zapic_jurnal" class="form-control" value="{{ old('zapic_jurnal') }}">
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
