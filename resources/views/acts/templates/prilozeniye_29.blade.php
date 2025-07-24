@extends('layouts.app')
@section('title', 'Акт освидетельствования и приемки полости пробуренной скважины')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width:1100px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">

            <h2 class="mb-4 text-center">
                Акт освидетельствования и приемки полости пробуренной скважины для бетонирования столба, скважин в основании оболочки, уширения
            </h2>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Строительная организация</label>
                    <input type="text" name="stroi_org" class="form-control" value="{{ old('stroi_org') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Объект, адрес</label>
                    <input type="text" name="name_address" class="form-control" value="{{ old('name_address') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Номер акта</label>
                    <input type="text" name="number_acts" class="form-control" value="{{ old('number_acts', $nextActNumber ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">№ фундамента</label>
                    <input type="text" name="number_fund" class="form-control" value="{{ old('number_fund') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">№ опоры</label>
                    <input type="text" name="number_opora" class="form-control" value="{{ old('number_opora') }}">
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

            <div class="mb-3"><label class="form-label">Комиссия (состав, должности, ФИО)</label>
                <textarea name="komisiya" class="form-control" rows="2" required>{{ old('komisiya') }}</textarea>
            </div>
            <div class="mb-3"><label class="form-label">Наименование строительной организации (комиссия)</label>
                <input type="text" name="name_stroi" class="form-control" value="{{ old('name_stroi') }}">
            </div>
            <div class="mb-3"><label class="form-label">ФИО, должность (строитель)</label>
                <input type="text" name="stroi_fio" class="form-control" value="{{ old('stroi_fio') }}">
            </div>
            <div class="mb-3"><label class="form-label">ФИО, должность (технадзор)</label>
                <input type="text" name="tn_fio" class="form-control" value="{{ old('tn_fio') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">№ уширения</label>
                    <input type="text" name="ushireniya_numb" class="form-control" value="{{ old('ushireniya_numb') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">№ опоры</label>
                    <input type="text" name="opora_numb" class="form-control" value="{{ old('opora_numb') }}">
                </div>
            </div>
            <div class="mb-3"><label class="form-label">Рабочие чертежи</label>
                <input type="text" name="chertej" class="form-control" value="{{ old('chertej') }}">
            </div>

            <h5 class="mt-3">Технические характеристики</h5>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Диаметр оболочки (м)</label>
                    <input type="text" name="diametr" class="form-control" value="{{ old('diametr') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Толщина стенки (см)</label>
                    <input type="text" name="tolshina" class="form-control" value="{{ old('tolshina') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Общая длина, м</label>
                    <input type="text" name="dlina" class="form-control" value="{{ old('dlina') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Отметка погружения, м</label>
                    <input type="text" name="otmetka" class="form-control" value="{{ old('otmetka') }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Диаметр скважины (м)</label>
                    <input type="text" name="skv_diametr" class="form-control" value="{{ old('skv_diametr') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Отметка верха скважины</label>
                    <input type="text" name="skv_verh" class="form-control" value="{{ old('skv_verh') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Отметка дна скважины</label>
                    <input type="text" name="skv_dno" class="form-control" value="{{ old('skv_dno') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Станок (нескал.)</label>
                    <input type="text" name="stanok_neskal" class="form-control" value="{{ old('stanok_neskal') }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Глубина нескального бурения (м)</label>
                    <input type="text" name="neskal_glubina" class="form-control" value="{{ old('neskal_glubina') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Станок (скальный)</label>
                    <input type="text" name="stanok_skal" class="form-control" value="{{ old('stanok_skal') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Глубина скального бурения (м)</label>
                    <input type="text" name="skal_glubina" class="form-control" value="{{ old('skal_glubina') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Диаметр уширения (м)</label>
                    <input type="text" name="diametr_razbur" class="form-control" value="{{ old('diametr_razbur') }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Отметка подошвы уширения</label>
                    <input type="text" name="otmetk_podoshv" class="form-control" value="{{ old('otmetk_podoshv') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Высота цилиндрической части (м)</label>
                    <input type="text" name="silindr_visota" class="form-control" value="{{ old('silindr_visota') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Уровень воды в скважине (м)</label>
                    <input type="text" name="uroven_vod" class="form-control" value="{{ old('uroven_vod') }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Отметка воды вне скважины (м)</label>
                    <input type="text" name="voda_vne" class="form-control" value="{{ old('voda_vne') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Грунт в основании</label>
                    <input type="text" name="grunt_osnov" class="form-control" value="{{ old('grunt_osnov') }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Отклонения: в плане вдоль моста (см)</label>
                    <input type="text" name="otkloneniya_vdol" class="form-control" value="{{ old('otkloneniya_vdol') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Отклонения: поперек моста (см)</label>
                    <input type="text" name="otkloneniya_poperek" class="form-control" value="{{ old('otkloneniya_poperek') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Отклонения по вертикали</label>
                    <input type="text" name="otkloneniya_vertical" class="form-control" value="{{ old('otkloneniya_vertical') }}">
                </div>
            </div>

            <hr>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Длина каркаса (м)</label>
                    <input type="text" name="dlina_karkas" class="form-control" value="{{ old('dlina_karkas') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Диаметр каркаса (м)</label>
                    <input type="text" name="diametr_karkas" class="form-control" value="{{ old('diametr_karkas') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Отметка низа каркаса</label>
                    <input type="text" name="niz_karkas" class="form-control" value="{{ old('niz_karkas') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Арматурный каркас с...</label>
                <input type="text" name="armkarkas_s" class="form-control" value="{{ old('armkarkas_s') }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Диаметр продольных стержней (мм)</label>
                    <input type="text" name="sterjen_diam" class="form-control" value="{{ old('sterjen_diam') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Количество продольных стержней</label>
                    <input type="text" name="sterjen_mm" class="form-control" value="{{ old('sterjen_mm') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Проект</label>
                <input type="text" name="project" class="form-control" value="{{ old('project') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">№ листа проекта</label>
                <input type="text" name="number_project" class="form-control" value="{{ old('number_project') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Установлено</label>
                <input type="text" name="ustanovleno" class="form-control" value="{{ old('ustanovleno') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Сопоставление с проектом, результат</label>
                <textarea name="postanovili" class="form-control">{{ old('postanovili') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Качество работ признать</label>
                <input type="text" name="kachestvo" class="form-control" value="{{ old('kachestvo') }}">
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
