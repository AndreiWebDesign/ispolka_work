@extends('layouts.app')
@section('title', 'Акт освидетельствования и приемки свайного фундамента (шпунтового ряда)')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:1100px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">

            <h2 class="mb-4 text-center">Акт освидетельствования и приемки свайного фундамента на забивных сваях (шпунтового ряда)</h2>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Номер акта (общий)</label>
                    <input type="text" name="number_acts_1" class="form-control" value="{{ old('number_acts_1', $nextActNumber ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Строительная организация</label>
                    <input type="text" name="stroi_org" class="form-control" value="{{ old('stroi_org') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Объект/адрес</label>
                    <input type="text" name="name_address" class="form-control" value="{{ old('name_address') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-2">
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
                <div class="col-md-4">
                    <label class="form-label">Комиссия (должности, ФИО)</label>
                    <input type="text" name="komisiya" class="form-control" value="{{ old('komisiya') }}" required>
                </div>
            </div>

            <hr>
            <h5 class="mt-3">Сведения о свайном основании и документации</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Рабочие чертежи</label>
                    <input type="text" name="svain_osn_1" class="form-control" value="{{ old('svain_osn_1') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ограждение котлована с креплением №</label>
                    <input type="text" name="svain_osn_2" class="form-control" value="{{ old('svain_osn_2') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Разработано (организация)</label>
                    <input type="text" name="svain_osn_3" class="form-control" value="{{ old('svain_osn_3') }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Крепление (№)</label>
                    <input type="text" name="krepleniye_numb" class="form-control" value="{{ old('krepleniye_numb') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Организация</label>
                    <input type="text" name="name_org" class="form-control" value="{{ old('name_org') }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Журнал производства работ №</label>
                    <input type="text" name="jurn_pr" class="form-control" value="{{ old('jurn_pr') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Журнал авторского надзора №</label>
                    <input type="text" name="jurn_an" class="form-control" value="{{ old('jurn_an') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Журнал технадзора №</label>
                    <input type="text" name="jurn_tn" class="form-control" value="{{ old('jurn_tn') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Отметка естественной поверхности грунта у котлована</label>
                <input type="text" name="otmetka_grunta" class="form-control" value="{{ old('otmetka_grunta') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Срезка грунта произведена до отметки</label>
                <input type="text" name="srezka_otmetka" class="form-control" value="{{ old('srezka_otmetka') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Котлован вырыт до отметки</label>
                <input type="text" name="vyryt_otmetka" class="form-control" value="{{ old('vyryt_otmetka') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Проектная отметка</label>
                <input type="text" name="project_otmetka" class="form-control" value="{{ old('project_otmetka') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Паспорта (на сваи)</label>
                <input type="text" name="passport-svai" class="form-control" value="{{ old('passport-svai') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Репер</label>
                    <input type="text" name="reper" class="form-control" value="{{ old('reper') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Отметка репера</label>
                    <input type="text" name="otmetka-reper" class="form-control" value="{{ old('otmetka-reper') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Крепление</label>
                <input type="text" name="krepleniye" class="form-control" value="{{ old('krepleniye') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Материал крепления</label>
                <input type="text" name="krep-material" class="form-control" value="{{ old('krep-material') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Глубина забивки (от, м)</label>
                    <input type="text" name="glubina_ot" class="form-control" value="{{ old('glubina_ot') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Глубина забивки (до, м)</label>
                    <input type="text" name="glubina_do" class="form-control" value="{{ old('glubina_do') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Глубина по проекту (м)</label>
                    <input type="text" name="glubina_project" class="form-control" value="{{ old('glubina_project') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Глубина организации (м)</label>
                    <input type="text" name="glubina_org" class="form-control" value="{{ old('glubina_org') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Соответствие проекту и состояние ограждения и крепления</label>
                <textarea name="sootvetstv" class="form-control" rows="2">{{ old('sootvetstv') }}</textarea>
            </div>
            <div class="mb-3">
                <label class
