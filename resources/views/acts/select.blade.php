@extends('layouts.app')
@section('title', 'Выбор типа акта')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="w-100" style="max-width: 700px;">
            <h2 class="mb-4 text-center">Выберите тип акта</h2>

            <div class="accordion" id="actTypeAccordion">
                @foreach($groupedActs as $groupName => $acts)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading_{{ md5($groupName) }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse_{{ md5($groupName) }}" aria-expanded="false"
                                    aria-controls="collapse_{{ md5($groupName) }}">
                                {{ $groupName }}
                            </button>
                        </h2>
                        <div id="collapse_{{ md5($groupName) }}" class="accordion-collapse collapse"
                             aria-labelledby="heading_{{ md5($groupName) }}"
                             data-bs-parent="#actTypeAccordion">
                            <div class="accordion-body p-2">
                                <ul class="list-group">
                                    @foreach($acts as $key => $label)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $label }}</span>
                                            <a href="{{ route('acts.create', ['passport' => $passport->id, 'type' => $key]) }}"
                                               class="btn btn-sm btn-primary">Создать</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
