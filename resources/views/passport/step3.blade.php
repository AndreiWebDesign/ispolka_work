@extends('layouts.app')
@section('title', 'Проверка доступа')

@section('content')
    <div class="container d-flex justify-content-center align-items-center">
        <div class="progresses">

            <div class="step-wrapper">
                <div class="steps_done">
                    <span><i class="bi bi-person-check"></i></span>
                </div>
                <div class="step-label">Участники</div>
            </div>

            <span class="line_done"></span>

            <div class="step-wrapper">
                <div class="steps_done">
                    <span><i class="bi bi-file-diff"></i></span>
                </div>
                <div class="step-label">Документация</div>
            </div>

            <span class="line_done"></span>

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
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h3 class="fw-bold mb-4 text-center">Проверка возможности создания паспорта</h3>

                @if($available > 0)
                    <div class="alert alert-success text-center">
                        <p>У вас доступно <strong>{{ $available }}</strong> {{ trans_choice('паспорт|паспорта|паспортов', $available, [], 'ru') }}.</p>
                        <p>После создания нового останется <strong>{{ $remaining }}</strong>.</p>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('passport.finish', ['id' => $passport->id]) }}" class="btn btn-primary px-4">Создать новый паспорт</a>

                    </div>
                @else
                    <div class="alert alert-danger text-center">
                        <p>У вас закончились доступные паспорта для создания.</p>
                        <p>Пожалуйста, перейдите к оплате, чтобы продолжить.</p>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('payments.index') }}" class="btn btn-outline-primary px-4">Перейти к оплате</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
