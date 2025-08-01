@extends('layouts.app')
@section('title', 'Создать акт скрытых работ')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('acts.store', $passport) }}" class="bg-white p-4 rounded shadow w-100" style="max-width: 900px;">
            @csrf
            <input type="hidden" name="passport_id" value="{{ $passport->id }}">
            <input type="hidden" name="type" value="{{ request('type') }}">
            <input type="hidden" name="heading_key" value="{{ $heading_key }}">
            <input type="hidden" name="heading_text" value="{{ $headingText }}">
            <h2 class="mb-4 text-center">
                <strong>Акт</strong>
                {{ $headingText ? ' ' . $headingText : ' освидетельствования скрытых работ' }}
            </h2>


            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Номер акта</label>
                    <input type="text" name="act_number" class="form-control"
                           value="{{ old('act_number', $nextActNumber) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Город</label>
                    <input type="text" name="city" class="form-control" value="{{ $passport->city ?? '' }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Дата составления</label>
                <input type="date" name="act_date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Наименование и место расположения объекта</label>
                <input type="text" name="object_name" class="form-control"
                       value="{{ trim(($passport->object_name ?? '') .
                         ($passport->city ? ', г. ' . $passport->city : '') .
                         ($passport->locality ? ', ' . $passport->locality : '')) }}"
                       required>
            </div>


            <h5 class="mt-4">Комиссия</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Представитель подрядчика (ФИО, организация, должность)</label>
                    <input type="text" name="contractor_representative" class="form-control"
                           value="{{ $passport->contractor_responsible ? $passport->contractor_responsible . ', ' . $passport->contractor : '' }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Представитель технадзора заказчика (ФИО, организация, должность)</label>
                    <input type="text" name="tech_supervisor_representative" class="form-control"
                           value="{{ $passport->tech_supervisor_responsible ? $passport->tech_supervisor_responsible . ', ' . $passport->tech_supervisor : '' }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Представитель проектной организации (если есть, ФИО, организация, должность)</label>
                    <input type="text" name="author_supervisor_representative" class="form-control"
                           value="{{ $passport->author_supervisor_responsible ? $passport->author_supervisor_responsible . ', ' . $passport->author_supervisor : '' }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Дополнительные участники освидетельствования (ФИО, организация, должность)</label>
                <textarea name="additional_participants" class="form-control" rows="2"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Выполнивший работы (наименование подрядчика/генподрядчика)</label>
                <input type="text" name="work_executor" class="form-control" value="{{ $passport->contractor ?? '' }}" required>
            </div>

            <h5 class="mt-4">1. К освидетельствованию предъявлены следующие работы</h5>
            <div class="mb-3">
                <label class="form-label">Наименование скрытых работ</label>
                <textarea name="hidden_works" id="hiddenWorks" class="form-control" rows="2" required></textarea>
            </div>

            <h5 class="mt-4">2. Работы выполнены по проектно-сметной документации</h5>
            <div class="mb-3">
                <label class="form-label">Наименование проектной организации, № чертежей, дата, идентификационные параметры</label>
                <textarea name="psd_info" class="form-control" rows="2" required>{{ $passport->project_developer ?? '' }}{{ $passport->psd_number ? ', ПСД №' . $passport->psd_number : '' }}</textarea>
            </div>

            <h5 class="mt-4">3. Применённые материалы, конструкции, изделия</h5>
            <div class="mb-3">
                <label class="form-label">Наименование материалов, изделий (с указанием сертификатов, документов, подтверждающих качество)</label>
                <textarea name="materials" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Дополнительные доказательства соответствия (исполнительные схемы, лабораторные заключения и др.)</label>
                <textarea name="compliance_evidence" class="form-control" rows="2"></textarea>
            </div>

            <h5 class="mt-4">4. Отклонения от проектно-сметной документации</h5>
            <div class="mb-3">
                <label class="form-label">Отклонения (отсутствуют/допущены, кем согласованы, № чертежей, дата согласования)</label>
                <textarea name="deviations" class="form-control" rows="2"></textarea>
            </div>

            <h5 class="mt-4">5. Даты выполнения работ</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Дата начала работ</label>
                    <input type="date" name="start_date" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Дата окончания работ</label>
                    <input type="date" name="end_date" class="form-control">
                </div>
            </div>

            <h5 class="mt-4">Решение комиссии</h5>
            <div class="mb-3">
                <label class="form-label">Решение</label>
                <select name="commission_decision" class="form-select" required>
                    <option value="">Выберите решение...</option>
                    <option value="Разрешается">Разрешается</option>
                    <option value="Запрещается">Запрещается</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Производство последующих работ по устройству (монтажу)</label>
                <input type="text" name="next_works" id="nextWorks" class="form-control">
            </div>

            @push('scripts')
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const hiddenWorks = document.getElementById('hiddenWorks');
                        const nextWorks = document.getElementById('nextWorks');
                        if (hiddenWorks && nextWorks) {
                            hiddenWorks.addEventListener('input', function () {
                                nextWorks.value = hiddenWorks.value;
                            });
                        }
                    });
                </script>
            @endpush

            <h5 class="mt-4">Подписи</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Представитель подрядчика (ФИО)</label>
                    <input type="text" name="contractor_sign_name" class="form-control" value="{{ $passport->contractor_responsible ?? '' }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Представитель технадзора заказчика (ФИО)</label>
                    <input type="text" name="tech_supervisor_sign_name" class="form-control" value="{{ $passport->tech_supervisor_responsible ?? '' }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Представитель авторского надзора (ФИО)</label>
                    <input type="text" name="author_supervisor_sign_name" class="form-control" value="{{ $passport->author_supervisor_responsible ?? '' }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Дополнительные участники (ФИО и подписи через запятую)</label>
                <textarea name="additional_signs" class="form-control" rows="2"></textarea>
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

