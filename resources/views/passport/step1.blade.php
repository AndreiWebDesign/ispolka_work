@extends('layouts.app')
@section('title', 'Добавить паспорт объекта')

@section('content')
    <div class="container d-flex justify-content-center align-items-center">
        <div class="progresses">

            <div class="step-wrapper">
                <div class="steps">
                    <span><i class="bi bi-person-check"></i></span>
                </div>
                <div class="step-label">Участники</div>
            </div>

            <span class="line"></span>

            <div class="step-wrapper">
                <div class="steps">
                    <span><i class="bi bi-file-diff"></i></span>
                </div>
                <div class="step-label">Документация</div>
            </div>

            <span class="line"></span>

            <div class="step-wrapper">
                <div class="steps">
                    <span><i class="bi bi-credit-card"></i></span>
                </div>
                <div class="step-label">Оплата</div>
            </div>
            <span class="line"></span>
            <div class="step-wrapper">
                <div class="steps">
                    <span><i class="bi bi-check"></i></span>
                </div>
                <div class="step-label">Финал</div>
            </div>

        </div>
    </div>

    <style>.progresses {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .line,.line_done {
            margin-bottom: 25px;
            width: 120px;
            height: 3px;
            background: #63d19e;
        }

        .line{
            background: #929ea745;
        }
         .line_done{
             background: #63d19e;
         }


        .step-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .steps,
        .steps_done {
            display: flex;
            color: #fff;
            font-size: 30px;
            width: 60px;
            height: 60px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;

        }

        .steps_done{
            background-color: #63d19e;
            border: 2px solid #3aaf7a;
        }

        .steps {
            background-color: #ffffff;
            color: #000000;
            border: 2px dashed #000000;
        }

        .step-label {
            margin-top: 5px;
            font-size: 14px;
            text-align: center;
            color: #333;
        }
    </style>

    <div class="container py-4 d-flex justify-content-center align-items-center" style="min-height: 70vh;">
                <!-- Stepper -->

        <form method="POST" action="{{ route('passport.storeStep1') }}" class="bg-white p-4 rounded shadow w-100" style="max-width: 700px;">
            @csrf

            <h2 class="mb-4 text-center">Добавить паспорт объекта</h2>

            <div class="mb-3">
                <label class="form-label">Название объекта</label>
                <input name="object_name" class="form-control" required>
            </div>

            <h5 class="mt-3">Участники строительства</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Заказчик</label>
                    <input name="customer" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ответственное лицо заказчика (опционально)</label>
                    <input name="customer_responsible" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Подрядчик</label>
                    <input name="contractor" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ответственное лицо подрядчика</label>
                    <input name="contractor_responsible" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Технический надзор</label>
                    <input name="tech_supervisor" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ответственное лицо технадзора</label>
                    <input name="tech_supervisor_responsible" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Авторский надзор</label>
                    <input name="author_supervisor" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ответственное лицо авторского надзора</label>
                    <input name="author_supervisor_responsible" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Разработчик проекта</label>
                    <input name="project_developer" class="form-control" required>
                </div>
            </div>

            <h5 class="mt-4">Расположение объекта</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Город</label>
                    <input name="city" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Населённый пункт</label>
                    <input name="locality" class="form-control">
                </div>
            </div>

            <h5 class="mt-4">Проектно-сметная документация</h5>
            <div class="mb-3">
                <label class="form-label">Номер ПСД</label>
                <input name="psd_number" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-4">Сохранить паспорт</button>
        </form>
    </div>

@endsection
