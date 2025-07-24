@extends('layouts.app')
@section('title', 'Акт осмотра открытых рвов и котлованов под фундаменты')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:1000px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">

            <h2 class="mb-4 text-center">Акт осмотра открытых рвов и котлованов под фундаменты</h2>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Номер акта</label>
                    <input type="text" name="act_number" class="form-control" value="{{ old('act_number', $nextActNumber ?? '') }}" required>
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
                <label class="form-label">Представитель технадзора застройщика</label>
                <input type="text" name="pred_tn_zastroi" class="form-control" value="{{ old('pred_tn_zastroi') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Инженер (1)</label>
                    <input type="text" name="injener_1" class="form-control" value="{{ old('injener_1') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Инженер (2)</label>
                    <input type="text" name="injener_2" class="form-control" value="{{ old('injener_2') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Главный инженер (1)</label>
                    <input type="text" name="glav_injener_1" class="form-control" value="{{ old('glav_injener_1') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Главный инженер (2)</label>
                    <input type="text" name="glav_injener_2" class="form-control" value="{{ old('glav_injener_2') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Производитель работ</label>
                <input type="text" name="proizod_rabot" class="form-control" value="{{ old('proizod_rabot') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Номер земельного участка</label>
                    <input type="text" name="number_zeml_uch" class="form-control" value="{{ old('number_zeml_uch') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Адрес участка</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Грунт на дне рвов и котлованов</label>
                <input type="text" name="grunt_vod" class="form-control" value="{{ old('grunt_vod') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Планировочная отметка по проекту</label>
                <input type="text" name="plan_otm" class="form-control" value="{{ old('plan_otm') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Глубина (от планировочной отметки)</label>
                <input type="text" name="glubina" class="form-control" value="{{ old('glubina') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Глубина в проекте (при необходимости)</label>
                <input type="text" name="glubina_v_prep" class="form-control" value="{{ old('glubina_v_prep') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Встреченные препятствия</label>
                <input type="text" name="prepyatstv" class="form-control" value="{{ old('prepyatstv') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Первоначально принятое основание</label>
                <input type="text" name="perv_osnov" class="form-control" value="{{ old('perv_osnov') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Допустимое давление на грунт (по проекту)</label>
                    <input type="text" name="davl_grunt" class="form-control" value="{{ old('davl_grunt') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Фактическое давление на грунт</label>
                    <input type="text" name="davl_grunt_2" class="form-control" value="{{ old('davl_grunt_2') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Давление по утвержденному проекту</label>
                    <input type="text" name="davl_project" class="form-control" value="{{ old('davl_project') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Укрепление основания вызвано</label>
                <input type="text" name="ukrep_vyzyv" class="form-control" value="{{ old('ukrep_vyzyv') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Необходимость осадочных швов</label>
                <input type="text" name="osad_sh" class="form-control" value="{{ old('osad_sh') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Комиссионное давление</label>
                <input type="text" name="kom_davlemiy" class="form-control" value="{{ old('kom_davlemiy') }}">
            </div>

            <div class="mb-3"><label class="form-label">Автор проекта / уполномоченный</label>
                <input type="text" name="avtor" class="form-control" value="{{ old('avtor') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Технадзор застройщика</label>
                <input type="text" name="tn_zastr" class="form-control" value="{{ old('tn_zastr') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Инженер (ещё 1)</label>
                <input type="text" name="inj_1" class="form-control" value="{{ old('inj_1') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Инженер (ещё 2)</label>
                <input type="text" name="inj_2" class="form-control" value="{{ old('inj_2') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Главный инженер</label>
                <input type="text" name="glav_injener" class="form-control" value="{{ old('glav_injener') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Производство работ</label>
                <input type="text" name="proizvod_rabot" class="form-control" value="{{ old('proizvod_rabot') }}">
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
