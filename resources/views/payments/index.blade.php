@extends('layouts.app')

@section('title', 'Оплата и тарифы')

@section('content')
    <div class="container py-5">
        <h2 class="mb-5 fw-bold text-center display-5">Оплата и тарифы</h2>

        {{-- Блок текущего тарифа --}}
        <div class="card border-0 shadow-sm rounded-4 mb-5 bg-body">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-person-badge-fill text-primary fs-3 me-2"></i>
                    <h5 class="mb-0 fw-semibold">Ваш текущий тариф</h5>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 text-center shadow-sm">
                            <div class="text-muted small">Тариф</div>
                            <div class="fw-semibold fs-5">{{ $user->tariff_name ?? 'Базовый' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 text-center shadow-sm">
                            <div class="text-muted small">Осталось документов</div>
                            <div class="fw-semibold fs-5">{{ $user->available_passports ?? 0}}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 text-center shadow-sm">
                            <div class="text-muted small">Статус оплаты</div>
                            @if($user->paid_until && \Carbon\Carbon::parse($user->paid_until)->isFuture())
                                <span class="badge bg-success px-3 py-2">до {{ \Carbon\Carbon::parse($user->paid_until)->format('d.m.Y') }}</span>
                            @else
                                <span class="badge bg-danger px-3 py-2">Не оплачено</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary rounded-pill">
                        <i class="bi bi-gear me-1"></i> Управление
                    </a>
                </div>
            </div>
        </div>

        {{-- Блок выбора тарифа --}}
        <h4 class="text-center mb-4 fw-semibold">Выберите подходящий тариф</h4>
        <div class="row g-4 justify-content-center mb-5">
            {{-- Free --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center rounded-4">
                    <div class="card-header bg-gradient text-white bg-primary fw-bold rounded-top-4">
                        Free
                    </div>
                    <div class="card-body">
                        <h3 class="fw-bold">0₸</h3>
                        <p class="text-muted small">Подходит для тестирования и индивидуального использования.</p>
                        <ul class="list-unstyled small mb-4">
                            <li>✔ 5 документов в месяц</li>
                            <li>✔ Email-поддержка</li>
                            <li>✖ Подпись ЭЦП</li>
                        </ul>
                        <form action="{{ route('dashboard') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tariff" value="free">
                            <button class="btn btn-outline-primary rounded-pill w-100">Выбрать</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Pro --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center rounded-4">
                    <div class="card-header bg-gradient text-white bg-success fw-bold rounded-top-4">
                        Pro
                    </div>
                    <div class="card-body">
                        <h3 class="fw-bold">2₸/мес</h3>
                        <p class="text-muted small">Для малого бизнеса и профессионалов.</p>
                        <ul class="list-unstyled small mb-4">
                            <li>✔ 100 документов в месяц</li>
                            <li>✔ Подпись ЭЦП</li>
                            <li>✔ Хранение в облаке</li>
                        </ul>
                        <form action="{{ route('dashboard') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tariff" value="pro">
                            <button class="btn btn-success rounded-pill w-100">Подключить</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Enterprise --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center rounded-4">
                    <div class="card-header bg-dark text-white fw-bold rounded-top-4">
                        Enterprise
                    </div>
                    <div class="card-body">
                        <h3 class="fw-bold">Договорная</h3>
                        <p class="text-muted small">Для корпораций и крупных проектов.</p>
                        <ul class="list-unstyled small mb-4">
                            <li>✔ Неограниченные документы</li>
                            <li>✔ API-доступ</li>
                            <li>✔ Интеграции</li>
                        </ul>
                        <a href="{{ route('dashboard') }}" class="btn btn-dark rounded-pill w-100">Запросить</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- История оплат --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-clock-history text-secondary fs-5 me-2"></i>
                    <h5 class="mb-0 fw-semibold">История оплат</h5>
                </div>

                @if(isset($payments) && count($payments) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-borderless mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Дата</th>
                                <th>Сумма</th>
                                <th>Метод</th>
                                <th>Комментарий</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $index => $payment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d.m.Y H:i') }}</td>
                                    <td><strong>{{ $payment->amount }} ₸</strong></td>
                                    <td>{{ $payment->method ?? '—' }}</td>
                                    <td>{{ $payment->comment ?? '—' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">Платежи не найдены.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
