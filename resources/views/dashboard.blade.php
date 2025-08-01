@extends('layouts.app')
@section('title', 'Панель управления')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold text-center mb-5">Панель управления</h2>

        <div class="row g-4">
            {{-- Левая колонка с графиками --}}
            <div class="col-lg-8">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card shadow rounded-4 border-0 h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 d-flex align-items-center">
                                    <i class="bi bi-graph-up-arrow text-success me-2 fs-5"></i>
                                    Статусы актов
                                </h5>
                                <canvas id="actsStatusChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow rounded-4 border-0 h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 d-flex align-items-center">
                                    <i class="bi bi-bar-chart-line text-primary me-2 fs-5"></i>
                                    Динамика за месяц
                                </h5>
                                <canvas id="actsMonthChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Правая колонка с уведомлениями --}}
            <div class="col-lg-4">
                <div class="card shadow rounded-4 border-0 h-100">
                    <div class="card-header bg-white border-0 d-flex align-items-center">
                        <i class="bi bi-bell-fill text-warning me-2 fs-5"></i>
                        <span class="fw-semibold">Уведомления</span>
                    </div>
                    <ul class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                        @forelse(auth()->user()->notifications->take(10) as $notification)
                            <li class="list-group-item position-relative">
                                <span class="badge rounded-pill
                                    {{ $notification->read_at ? 'bg-secondary' : 'bg-success' }} me-2">
                                    {{ $notification->read_at ? 'Прочитано' : 'Новое' }}
                                </span>
                                {{ $notification->data['message'] ?? 'Уведомление' }}
                                <small class="text-muted d-block">{{ $notification->created_at->diffForHumans() }}</small>
                                <a href="{{ route('notifications.show', $notification->id) }}" class="stretched-link"></a>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Нет уведомлений</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Статусы актов
            const ctxStatus = document.getElementById('actsStatusChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Принятые', 'В обработке', 'Отклоненные'],
                    datasets: [{
                        data: [42, 17, 5], // Замените на реальные данные
                        backgroundColor: [
                            'rgba(25, 135, 84, 0.85)',
                            'rgba(255, 193, 7, 0.85)',
                            'rgba(220, 53, 69, 0.85)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: true, position: 'bottom' }
                    }
                }
            });

            // Динамика по месяцам
            const ctxMonth = document.getElementById('actsMonthChart').getContext('2d');
            new Chart(ctxMonth, {
                type: 'line',
                data: {
                    labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                    datasets: [{
                        label: 'Создано актов',
                        data: @json($monthlyActs),
                        fill: true,
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderColor: 'rgba(13, 110, 253, 1)',
                        tension: 0.4
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        </script>
    @endpush
@endsection
