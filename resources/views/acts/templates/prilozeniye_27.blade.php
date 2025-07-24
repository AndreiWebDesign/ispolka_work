@extends('layouts.app')
@section('title', 'Акт освидетельствования и приемки котлована')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:1100px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">

            <h2 class="mb-4 text-center">Акт освидетельствования и приемки котлована</h2>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Строительная организация</label>
                    <input type="text" name="stroi_org" class="form-control" value="{{ old('stroi_org') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Объект/адрес</label>
                    <input type="text" name="name_address" class="form-control" value="{{ old('name_address') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Номер акта</label>
                    <input type="text" name="number_acts" class="form-control" value="{{ old('number_acts', $nextActNumber ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Котлован под</label>
                    <input type="text" name="kotlovan_pod" class="form-control" value="{{ old('kotlovan_pod') }}">
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
                <label class="form-label">Комиссия (ФИО, должности)</label>
                <input type="text" name="komisia_fio" class="form-control" value="{{ old('komisia_fio') }}" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Основание комиссии 1</label>
                    <input type="text" name="komisia_osn" class="form-control" value="{{ old('komisia_osn') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Основание комиссии 2</label>
                    <input type="text" name="komisia_osn_2" class="form-control" value="{{ old('komisia_osn_2') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Основание комиссии 3</label>
                    <input type="text" name="komisia_osn_3" class="form-control" value="{{ old('komisia_osn_3') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Подошва</label>
                <input type="text" name="pod" class="form-control" value="{{ old('pod') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Номер крепления</label>
                <input type="text" name="number_krep" class="form-control" value="{{ old('number_krep') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Разработал</label>
                <input type="text" name="razrab" class="form-control" value="{{ old('razrab') }}">
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Журнал работ №</label>
                    <input type="text" name="jurnal_rb_number" class="form-control" value="{{ old('jurnal_rb_number') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Журнал №</label>
                    <input type="text" name="jurnal_number" class="form-control" value="{{ old('jurnal_number') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Акт №</label>
                    <input type="text" name="akt_number" class="form-control" value="{{ old('akt_number') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Ведомость</label>
                <input type="text" name="vedomost" class="form-control" value="{{ old('vedomost') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Естественная поверхность</label>
                <input type="text" name="estestv_poverh" class="form-control" value="{{ old('estestv_poverh') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Отметка котлована</label>
                <input type="text" name="kotlovan_otm" class="form-control" value="{{ old('kotlovan_otm') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Проектная отметка</label>
                <input type="text" name="project_otm" class="form-control" value="{{ old('project_otm') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Репер №</label>
                    <input type="text" name="reper_number" class="form-control" value="{{ old('reper_number') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Отметка репера</label>
                    <input type="text" name="reper_otm" class="form-control" value="{{ old('reper_otm') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Выпуск из</label>
                <input type="text" name="vyp_iz" class="form-control" value="{{ old('vyp_iz') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">От дна</label>
                    <input type="text" name="ot_dna" class="form-control" value="{{ old('ot_dna') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">До, м</label>
                    <input type="text" name="do_m" class="form-control" value="{{ old('do_m') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Глубина забивки</label>
                <input type="text" name="glubina_zabivki" class="form-control" value="{{ old('glubina_zabivki') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Верх организации</label>
                <input type="text" name="verh_org" class="form-control" value="{{ old('verh_org') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Отклонения шпунта</label>
                <input type="text" name="otkloneniya_shpunt" class="form-control" value="{{ old('otkloneniya_shpunt') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Крепление верхнее</label>
                <input type="text" name="krep_verh" class="form-control" value="{{ old('krep_verh') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Обвязка</label>
                <input type="text" name="obvyazka" class="form-control" value="{{ old('obvyazka') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Замкнутость шпунта</label>
                <input type="text" name="zamknutost_shpunt" class="form-control" value="{{ old('zamknutost_shpunt') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Номер приложения</label>
                <input type="text" name="number_prilojeniya" class="form-control" value="{{ old('number_prilojeniya') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Отметка воды</label>
                    <input type="text" name="otmetka_vod" class="form-control" value="{{ old('otmetka_vod') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Отметка рабочего горизонта воды</label>
                    <input type="text" name="otmetka_rab_gorizont_vod" class="form-control" value="{{ old('otmetka_rab_gorizont_vod') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Водоотлив</label>
                    <input type="text" name="vodootliv" class="form-control" value="{{ old('vodootliv') }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Грунт дна</label>
                    <input type="text" name="grunt_dno" class="form-control" value="{{ old('grunt_dno') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Глубина шпунта</label>
                    <input type="text" name="glubina_shunt" class="form-control" value="{{ old('glubina_shunt') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Идет</label>
                    <input type="text" name="idet" class="form-control" value="{{ old('idet') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Заглушка ключ</label>
                <input type="text" name="zaglush_key" class="form-control" value="{{ old('zaglush_key') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Испытание грунта</label>
                <input type="text" name="ispytaniya_grunt" class="form-control" value="{{ old('ispytaniya_grunt') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Расчетное сопротивление</label>
                <input type="text" name="rachet_sopr" class="form-control" value="{{ old('rachet_sopr') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Сопротивление по проекту</label>
                <input type="text" name="sopr_project" class="form-control" value="{{ old('sopr_project') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Отметка разрыхления</label>
                <input type="text" name="otmetka_razr" class="form-control" value="{{ old('otmetka_razr') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">День (шпунт)</label>
                    <input type="number" name="day_shunt" class="form-control" value="{{ old('day_shunt') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Месяц (шпунт)</label>
                    <input type="text" name="month_shunt" class="form-control" value="{{ old('month_shunt') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Год (шпунт)</label>
                    <input type="number" name="year_shunt" class="form-control" value="{{ old('year_shunt') }}">
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
