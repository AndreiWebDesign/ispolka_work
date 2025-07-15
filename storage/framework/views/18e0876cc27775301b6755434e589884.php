<?php $__env->startSection('title', 'Панель управления'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 mb-4">
            <h3>Добро пожаловать, <?php echo e(Auth::user()->name); ?>!</h3>
        </div>
        <div class="col-md-7 py-4">
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Статусы актов</h5>
                            <canvas id="actsStatusChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Динамика актов за месяц</h5>
                            <canvas id="actsMonthChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Можно добавить еще графики или виджеты -->
        </div>
        <div class="col-md-3 py-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class="bi bi-bell-fill text-primary me-2"></i>
                    <span class="fw-semibold">Уведомления</span>
                </div>
                <ul class="list-group list-group-flush" style="max-height: 350px; overflow-y: auto;">
                    <li class="list-group-item">
                        <span class="badge bg-success me-2">Новое</span>
                        Акт №123 принят комиссией.
                        <small class="text-muted d-block">5 минут назад</small>
                    </li>
                    <li class="list-group-item">
                        <span class="badge bg-warning text-dark me-2">В обработке</span>
                        Акт №124 ожидает подписи.
                        <small class="text-muted d-block">1 час назад</small>
                    </li>
                    <li class="list-group-item">
                        <span class="badge bg-danger me-2">Отклонено</span>
                        Акт №122 отклонен (ошибка в документации).
                        <small class="text-muted d-block">Вчера</small>
                    </li>
                    <li class="list-group-item">
                        <span class="badge bg-info text-dark me-2">Инфо</span>
                        Добавлен новый объект: ЖК "Арман".
                        <small class="text-muted d-block">2 дня назад</small>
                    </li>
                    <!-- Еще уведомления -->
                </ul>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // График статусов актов (Pie)
            const ctxStatus = document.getElementById('actsStatusChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Принятые', 'В обработке', 'Отклоненные'],
                    datasets: [{
                        data: [42, 17, 5], // Здесь можно подставить реальные данные из контроллера
                        backgroundColor: [
                            'rgba(25, 135, 84, 0.8)',    // Принятые - зеленый
                            'rgba(255, 193, 7, 0.8)',    // В обработке - желтый
                            'rgba(220, 53, 69, 0.8)'     // Отклоненные - красный
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

            // График динамики по месяцам (Line)
            const ctxMonth = document.getElementById('actsMonthChart').getContext('2d');
            new Chart(ctxMonth, {
                type: 'line',
                data: {
                    labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл'],
                    datasets: [{
                        label: 'Создано актов',
                        data: [5, 9, 14, 22, 18, 26, 31], // Примерные данные
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
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/ispolka/resources/views/dashboard.blade.php ENDPATH**/ ?>