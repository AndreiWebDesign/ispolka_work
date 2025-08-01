@extends('layouts.app')
@section('title', 'Объекты')

@section('content')
    <div class="container py-4">
        <ul class="nav nav-tabs mb-4" id="passportTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
                    Завершённые
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="drafts-tab" data-bs-toggle="tab" data-bs-target="#drafts" type="button" role="tab">
                    Черновики
                </button>
            </li>
        </ul>

        <div class="tab-content" id="passportTabsContent">
            {{-- Завершённые --}}
            <div class="tab-pane fade show active" id="completed" role="tabpanel">
                @forelse ($completedPassports as $passport)
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-1">{{ $passport->object_name ?? 'Без названия' }}</h5>
                            <p class="text-muted mb-2">ПСД: {{ $passport->psd_number }}</p>
                            <a href="{{ route('projects.show', $passport->id) }}" class="btn btn-outline-primary">Просмотр</a>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Нет завершённых паспортов.</p>
                @endforelse
            </div>

            {{-- Черновики --}}
            <div class="tab-pane fade" id="drafts" role="tabpanel">
                @forelse ($draftPassports as $passport)
                    <div class="card mb-3 border-warning">
                        <div class="card-body">
                            <h5 class="mb-1">{{ $passport->object_name ?? 'Без названия' }}</h5>
                            <p class="text-muted mb-2">ПСД: {{ $passport->psd_number }}</p>

                            {{-- Кнопка продолжения создания --}}
                            @if ($passport->step === 1)
                                <a href="{{ route('passport.step2', $passport->id) }}" class="btn btn-warning">Продолжить создание (Шаг 2)</a>
                            @elseif ($passport->step === 2)
                                <a href="{{ route('passport.step3', $passport->id) }}" class="btn btn-warning">Продолжить создание (Шаг 33)</a>
                            @else
                                <a href="{{ route('passport.finish', $passport->id) }}" class="btn btn-warning">Завершить</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Нет черновиков.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
