@extends('layouts.app')
@section('title', 'Отчёт по актам')

@section('content')
    @php
        use Illuminate\Support\Str;

        // Подсчёт общего количества и заполненных актов
        $totalActs = 0;
        $filledActs = 0;

        foreach ($groupedActs as $acts) {
            foreach ($acts as $act) {
                $totalActs++;
                if (!empty($act['exists'])) {
                    $filledActs++;
                }
            }
        }
    @endphp

    <div class="container py-4">
        <h2 class="mb-4">Отчёт по актам для объекта: {{ $passport->object_name ?? 'ID ' . $passport->id }}</h2>

        <div class="mb-3">
            <p><strong>Всего актов:</strong> {{ $totalActs }}</p>
            <p><strong>Заполнено актов:</strong> {{ $filledActs }}</p>
        </div>

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

                                        $fullLabel = Str::startsWith(Str::lower($label), 'скрытых')
                                            ? 'Акт ' . $label
                                            : $label;

                                        $type = $isHidden ? 'hidden_works' : $typeOrKey;

                                        $url = route('acts.create', [
                                            'passport' => $passport,
                                            'type' => $type,
                                            'heading_key' => $typeOrKey,
                                        ]);
                                    @endphp
                                    <div class="col">
                                        <a href="{{ $url }}"
                                           class="d-block act-link p-3 text-decoration-none rounded text-white {{ $act['exists'] ? 'bg-success' : 'bg-danger' }}">
                                            {{ $fullLabel }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
