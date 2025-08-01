@extends('layouts.app')
@section('title', 'Выбор типа акта')

@section('content')
    <div class="container py-5 d-flex flex-column align-items-center" style="min-height: 70vh;">
        <h2 class="mb-3 text-center fw-bold" style="font-size:2.1rem;">Выберите раздел (группу) актов</h2>
        <p class="lead mb-5 text-center" style="max-width: 600px;">
            Нажмите на интересующий раздел, чтобы раскрыть полный список вариантов актов.<br>
            Затем выберите конкретный акт для заполнения.
        </p>

        <div class="accordion w-100" id="actsAccordion" style="max-width: 1120px;">
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
                                        $isHidden = $act['is_hidden'] ?? false;
                                        $fullLabel = \Illuminate\Support\Str::startsWith($label, 'Акт') ? $label : 'Акт ' . $label;
                                        $type = $isHidden ? 'hidden_works' : $typeOrKey;
                                        $url = route('acts.create', [
                                            'passport' => $passport,
                                            'type' => $type,
                                            'heading_key' => $typeOrKey,
                                        ]);
                                    @endphp
                                    <div class="col">
                                        <a href="{{ $url }}" class="d-block act-link p-3 text-decoration-none">{{ $fullLabel }}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .act-link {
            font-weight: 600;
            font-size: 1.04rem;
            color: #000000 !important;
            border: 1.5px solid #e3e3eb !important;
            box-shadow: 0 2px 6px rgba(57,125,255,0.08);
            background: #fff !important;
            transition: background .17s, color .17s, box-shadow .16s, border .16s;
        }
        .act-link:hover, .act-link:focus {
            background-color: #eef5ff !important;
            color: #1b51b0 !important;
            border-color: #90b3f0 !important;
            box-shadow: 0 3px 14px rgba(37,99,235,.13)!important;
            text-decoration: none;
        }
        .accordion-item {
            background: #fff !important;
            border: none !important;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
        }
        .accordion-button {
            min-height: 72px;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            font-size: 1.1rem;
            color: #1f2937;
        }
        .accordion-button:not(.collapsed) {
            color: #1b51b0;
            background-color: #eef5ff;
            box-shadow: none;
        }
        .accordion-body {
            background: #fff !important;
            transition: all 0.3s ease;
        }
    </style>
@endsection
