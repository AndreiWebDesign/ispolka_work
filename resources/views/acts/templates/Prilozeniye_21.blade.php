@extends('layouts.app')
@section('title', 'Создать акт приёмки геодезической разбивочной основы')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width: 900px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">
            <h2 class="mb-4 text-center">Акт приёмки геодезической разбивочной основы для строительства</h2>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Номер акта</label>
                    <input type="text" name="number_acts" class="form-control" value="{{ old('number_acts', $nextActNumber ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Город</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $passport->city ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">День</label>
                    <input type="number" min="1" max="31" name="day" class="form-control" value="{{ old('day', date('d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Месяц</label>
                    <input type="text" name="month" class="form-control" value="{{ old('month', date('m')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Год</label>
                    <input type="number" min="2000" max="2100" name="year" class="form-control" value="{{ old('year', date('Y')) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Наименование объекта строительства</label>
                <input type="text" name="name_object" class="form-control" value="{{ old('name_object', $passport->object_name ?? '') }}" required>
            </div>

            <h5 class="mt-4">Комиссия в составе</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Ответственный представитель заказчика (ФИО, должность)</label>
                    <input type="text" name="pred_zakaz" class="form-control" value="{{ old('pred_zakaz') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Представитель технадзора (ФИО, должность, № аттестата)</label>
                    <input type="text" name="pred_tn" class="form-control" value="{{ old('pred_tn') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Генподрядная строительно-монтажная организация (ФИО, должность)</label>
                    <input type="text" name="pred_gp" class="form-control" value="{{ old('pred_gp') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Техническая документация на геодезическую разбивочную основу</label>
                <textarea name="geodez_docs" class="form-control" rows="2" required>{{ old('geodez_docs') }}</textarea>
                <small class="text-muted">Укажите наименование объекта, вид документации. Например: "Документация на геодезическую разбивочную основу для [объект]"</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Техническая документация (проектная организация, номера чертежей, дата выпуска)</label>
                <textarea name="tech_docs_1" class="form-control" rows="2" required>{{ old('tech_docs_1') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Соответствие технической документации</label>
                <textarea name="tech_docs_2" class="form-control" rows="2">{{ old('tech_docs_2') }}</textarea>
                <small class="text-muted">При необходимости можно отметить дополнительные детали соответствия документации</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Приложения (чертежи, ведомости и т. д.)</label>
                <textarea name="prilojenie_1" class="form-control" rows="2">{{ old('prilojenie_1') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Другие приложения</label>
                <textarea name="prilojenie_2" class="form-control" rows="2">{{ old('prilojenie_2') }}</textarea>
            </div>

            <h5 class="mt-4">Подписи</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Представитель технадзора (подпись)</label>
                    <input type="text" name="sign_tn" class="form-control" value="{{ old('sign_tn') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Представитель подрядчика (производитель работ, подпись)</label>
                    <input type="text" name="sign_gp" class="form-control" value="{{ old('sign_gp') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Работник геодезической службы (подпись)</label>
                    <input type="text" name="sign_geodez" class="form-control" value="{{ old('sign_geodez') }}">
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
