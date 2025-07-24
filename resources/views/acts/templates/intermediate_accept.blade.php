@extends('layouts.app')
@section('title', 'Создать акт промежуточной приёмки ответственных конструкций')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width: 900px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="intermediate_accept">

            <h2 class="mb-4 text-center">Акт № <input type="text" name="act_number" class="border-0 border-bottom" style="width:60px;" value="{{ old('act_number', $nextActNumber) }}" required>
                промежуточной приёмки ответственных конструкций</h2>

            <div class="mb-3">
                <label class="form-label">Дата составления</label>
                <input type="date" name="act_date" class="form-control" value="{{ old('act_date', date('Y-m-d')) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Наименование и место расположения объекта</label>
                <input type="text" name="object_name" class="form-control" value="{{ old('object_name', $passport->object_name ?? '') }}" required>
            </div>

            <h5 class="mt-4">Комиссия</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Представитель подрядчика (ФИО, организация, должность)</label>
                    <input type="text" name="contractor_representative" class="form-control"
                           value="{{ old('contractor_representative', $passport->contractor_responsible ? $passport->contractor_responsible . ', ' . $passport->contractor : '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Представитель технадзора заказчика (ФИО, организация, должность)</label>
                    <input type="text" name="tech_supervisor_representative" class="form-control"
                           value="{{ old('tech_supervisor_representative', $passport->tech_supervisor_responsible ? $passport->tech_supervisor_responsible . ', ' . $passport->tech_supervisor : '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Представитель проектной организации (если есть, ФИО, организация, должность)</label>
                    <input type="text" name="author_supervisor_representative" class="form-control"
                           value="{{ old('author_supervisor_representative', $passport->author_supervisor_responsible ? $passport->author_supervisor_responsible . ', ' . $passport->author_supervisor : '') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Дополнительные участники (ФИО, организация, должность, через запятую)</label>
                <textarea name="additional_participants" class="form-control" rows="2">{{ old('additional_participants') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Выполнивший работы (наименование подрядчика/генподрядчика)</label>
                <input type="text" name="work_executor" class="form-control" value="{{ old('work_executor', $passport->contractor ?? '') }}" required>
            </div>

            <h5 class="mt-4">1. К приёмке предъявлены следующие конструкции (системы)</h5>
            <div class="mb-3">
                <label class="form-label">Перечень и краткая характеристика конструкций</label>
                <textarea name="inspected_constructions" class="form-control" rows="2" required>{{ old('inspected_constructions') }}</textarea>
            </div>

            <h5 class="mt-4">2. Работы выполнены по проектно-сметной документации</h5>
            <div class="mb-3">
                <label class="form-label">Наименование проектной организации, № чертежей, даты, параметры</label>
                <textarea name="project_docs" class="form-control" rows="2" required>{{ old('project_docs', $passport->project_developer ?? '') }}{{ $passport->psd_number ? ', ПСД №' . $passport->psd_number : '' }}</textarea>
            </div>

            <h5 class="mt-4">3. Применённые материалы, конструкции, изделия</h5>
            <div class="mb-3">
                <label class="form-label">Наименование материалов (с указанием сертификатов, документов и др.)</label>
                <textarea name="materials_used" class="form-control" rows="2">{{ old('materials_used') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Освидетельствованы скрытые работы, входящие в состав конструкций (виды скрытых работ и № актов)</label>
                <textarea name="hidden_works" class="form-control" rows="2">{{ old('hidden_works') }}</textarea>
            </div>

            <h5 class="mt-4">4. Документы, подтверждающие соответствие</h5>
            <div class="mb-3">
                <label class="form-label">Исполнительные геодезические схемы (дата, номер, ФИО, должность)</label>
                <textarea name="geo_schemes" class="form-control" rows="2">{{ old('geo_schemes') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Заключения лаборатории по прочности бетона (дата, номер, ФИО, должность)</label>
                <textarea name="lab_reports" class="form-control" rows="2">{{ old('lab_reports') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Документы по контролю сварных соединений</label>
                <textarea name="weld_docs" class="form-control" rows="2">{{ old('weld_docs') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Дополнительная производственная документация</label>
                <textarea name="production_docs" class="form-control" rows="2">{{ old('production_docs') }}</textarea>
            </div>

            <h5 class="mt-4">5. Испытания и опробования</h5>
            <div class="mb-3">
                <label class="form-label">Наименования испытаний, № и даты документов</label>
                <textarea name="test_info" class="form-control" rows="2">{{ old('test_info') }}</textarea>
            </div>

            <h5 class="mt-4">6. Отклонения от проектно-сметной документации</h5>
            <div class="mb-3">
                <label class="form-label">Отклонения (отсутствуют/допущены, кем согласованы, № чертежей, дата согласования)</label>
                <textarea name="deviations" class="form-control" rows="2">{{ old('deviations') }}</textarea>
            </div>

            <h5 class="mt-4">7. Даты выполнения работ</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Дата начала работ</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Дата окончания работ</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                </div>
            </div>

            <h5 class="mt-4">Решение комиссии</h5>
            <div class="mb-3">
                <label class="form-label">Решение</label>
                <textarea name="commission_decision" class="form-control" rows="2" required>{{ old('commission_decision', 'Предъявленные конструкции (системы) выполнены в соответствии с проектно-сметной документацией и считаются принятыми.') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Производство последующих работ (монтаж, конструкция и др.)</label>
                <textarea name="further_work_allowed" class="form-control" rows="2">{{ old('further_work_allowed') }}</textarea>
            </div>

            <h5 class="mt-4">Подписи</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Представитель подрядчика (ФИО)</label>
                    <input type="text" name="contractor_sign_name" class="form-control" value="{{ old('contractor_sign_name', $passport->contractor_responsible ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Представитель технадзора заказчика (ФИО)</label>
                    <input type="text" name="tech_supervisor_sign_name" class="form-control" value="{{ old('tech_supervisor_sign_name', $passport->tech_supervisor_responsible ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Представитель авторского надзора (ФИО)</label>
                    <input type="text" name="author_supervisor_sign_name" class="form-control" value="{{ old('author_supervisor_sign_name', $passport->author_supervisor_responsible ?? '') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Дополнительные участники (ФИО и подписи через запятую)</label>
                <textarea name="additional_signs" class="form-control" rows="2">{{ old('additional_signs') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Дополнительная информация</label>
                <textarea name="additional_info" class="form-control" rows="2">{{ old('additional_info') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Приложения (указать перечень прилагаемых документов)</label>
                <textarea name="appendices" class="form-control" rows="2">{{ old('appendices') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Сохранить акт</button>
        </form>
    </div>
    @if (session('pdf_error'))
        <script>
            console.error("PDF Error:", @json(session('pdf_error')));
        </script>
    @endif

    @if (session('error'))
        <script>
            console.error("Ошибка:", @json(session('error')));
        </script>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
