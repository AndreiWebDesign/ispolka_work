@extends('layouts.app')
@section('title', 'Добавить паспорт объекта')

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

    <style>
        .progresses {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .line, .line_done {
            margin-bottom: 25px;
            width: 120px;
            height: 3px;
        }
        .line {
            background: #929ea745;
        }
        .line_done {
            background: #63d19e;
        }
        .step-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .steps, .steps_done {
            display: flex;
            color: #fff;
            font-size: 30px;
            width: 60px;
            height: 60px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .steps_done {
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
        .act-link {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        .act-link:hover {
            background-color: #e2e6ea;
        }
    </style>

    <div class="container py-4 d-flex justify-content-center align-items-start" style="min-height: 70vh;">
        <form method="POST" action="{{ route('passport.storeStep2', $passport->id) }}" class="w-100" style="max-width: 1120px;">
            @csrf

            <div class="accordion" id="actsAccordion">
                @foreach ($groupedActs as $groupTitle => $acts)
                    @php $accordionId = 'actGroup' . md5($groupTitle); @endphp
                    <div class="accordion-item mb-3 rounded-1 shadow-sm border-0">
                        <h2 class="accordion-header" id="{{ $accordionId }}-heading">
                            <button class="accordion-button collapsed fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#{{ $accordionId }}-collapse"
                                    aria-expanded="false" aria-controls="{{ $accordionId }}-collapse">
                                {{ $groupTitle }}
                            </button>
                        </h2>
                        <div id="{{ $accordionId }}-collapse"
                             class="accordion-collapse collapse"
                             aria-labelledby="{{ $accordionId }}-heading"
                             data-bs-parent="#actsAccordion">
                            <div class="accordion-body pb-3">
                                <div class="row row-cols-1 row-cols-md-2 g-3">
                                    @foreach ($acts as $typeOrKey => $act)
                                        @php
                                            $label = $act['label'] ?? $typeOrKey;
                                        @endphp
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="acts[]" value="{{ $typeOrKey }}"
                                                       id="act_{{ $typeOrKey }}">
                                                <label class="form-check-label" for="act_{{ $typeOrKey }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Продолжить</button>
            </div>
        </form>
    </div>
@endsection
