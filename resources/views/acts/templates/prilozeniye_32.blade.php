@extends('layouts.app')
@section('title', 'Акт приемки ответственных специальных вспомогательных сооружений')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:1000px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">

            <h2 class="mb-4 text-center">
                Акт приемки ответственных специальных вспомогательных сооружений (приспособлений, устройств) для строительства мостового сооружения
            </h2>

            <div class="row mb-3">
                <div class="col-md-5">
                    <label class="form-label">Строительная организация</label>
                    <input type="text" name="stroi_org" class="form-control" value="{{ old('stroi_org') }}" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Строительство (наименование и месторасположение)</label>
                    <input type="text" name="name_address" class="form-control" value="{{ old('name_address') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Номер акта</label>
                    <input type="text" name="number_acts" class="form-control" value="{{ old('number_acts', $nextActNumber ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-2">
                    <label class="form-label">День</label>
                    <input type="number" name="day#0" class="form-control" value="{{ old('day#0', date('d')) }}" required>
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

            <h5 class="mt-4 mb-2">Комиссия</h5>
            <div class="mb-3">
                <label class="form-label">Состав комиссии (должность, ФИО)</label>
                <input type="text" name="komisia" class="form-control" value="{{ old('komisia') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Действующая на основании</label>
                <input type="text" name="osnovaniye" class="form-control" value="{{ old('osnovaniye') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Наименование, месторасположение и назначение сооружения/устройства</label>
                <textarea name="name_adress_naznacheniye_2" class="form-control" rows="2">{{ old('name_adress_naznacheniye_2') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Рабочие чертежи №</label>
                <input type="text" name="rabochie" class="form-control" value="{{ old('rabochie') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Разработанные (организация)</label>
                <input type="text" name="razrabotanye" class="form-control" value="{{ old('razrabotanye') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Отклонения от проекта согласованы с</label>
                <input type="text" name="otklonenie_1" class="form-control" value="{{ old('otklonenie_1') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Дата согласования (день)</label>
                    <input type="number" name="day#1" class="form-control" value="{{ old('day#1') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Год согласования</label>
                    <input type="number" name="year_sogl" class="form-control" value="{{ old('year_sogl') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Наименование, месторасположение, назначение (ещё раз, по форме)</label>
                <textarea name="name_adress_naznacheniye_1" class="form-control" rows="2">{{ old('name_adress_naznacheniye_1') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Журнал производства работ №</label>
                <input type="text" name="jurnal_proizv" class="form-control" value="{{ old('jurnal_proizv') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Журнал авторского надзора №</label>
                <input type="text" name="jurnan_avtor" class="form-control" value="{{ old('jurnan_avtor') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Акты предшествующих приемок №</label>
                <input type="text" name="akts" class="form-control" value="{{ old('akts') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Сертификаты соответствия №</label>
                <input type="text" name="sertifikat" class="form-control" value="{{ old('sertifikat') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Паспорта №</label>
                <input type="text" name="passport" class="form-control" value="{{ old('passport') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Результаты освидетельствования инвентарных металлических конструкций</label>
                <input type="text" name="ustanovila_1" class="form-control" value="{{ old('ustanovila_1') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Комиссия установила</label>
                <textarea name="ustanovila_2" class="form-control" rows="2">{{ old('ustanovila_2') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Работы считать выполненными и принятыми (наименование сооружения, устройства)</label>
                <input type="text" name="chitat_rabots" class="form-control" value="{{ old('chitat_rabots') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Качество работ признать</label>
                <input type="text" name="priznat" class="form-control" value="{{ old('priznat') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Разрешить дальнейшее производство работ по</label>
                <input type="text" name="razreshit" class="form-control" value="{{ old('razreshit') }}">
            </div>

            <p class="text-secondary mt-4">Приложения: исполнительная схема положения вспомогательного сооружения (устройства), журналы, ведомости и т.д.</p>

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
