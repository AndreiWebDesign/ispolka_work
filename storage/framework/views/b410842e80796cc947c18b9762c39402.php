<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'eCTN'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS и иконки -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex flex-column">

<!-- Шапка -->
<div class="container-fluid bg-primary py-2 mb-4">
    <div class="container d-flex align-items-center">
        <span class="fs-3 fw-bold text-white me-3">eCTN</span>
        <span class="text-white ms-auto d-flex align-items-center">
                <i class="bi bi-bell me-3"></i>
                <i class="bi bi-person-circle ms-3"></i>
                <?php if(auth()->guard()->check()): ?>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline ms-3">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger btn-sm">Выйти</button>
                    </form>
            <?php endif; ?>
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-sm ms-3">Войти</a>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-sm ms-2">Регистрация</a>
            <?php endif; ?>
            </span>
    </div>
</div>

<div class="container flex-grow-1">
    <div class="row">
        <!-- Боковое меню -->
        <div class="col-md-2 mb-4">
            <div class="list-group">
                <a href="<?php echo e(url('/')); ?>" class="list-group-item list-group-item-action <?php echo e(request()->is('/') ? 'active' : ''); ?>">Главная</a>
                <a href="#" class="list-group-item list-group-item-action">Создать документ</a>
                <a href="#" class="list-group-item list-group-item-action">Исполнительная документация</a>
                <a href="<?php echo e(route('projects.index')); ?>" class="list-group-item list-group-item-action <?php echo e(request()->routeIs('projects.index') ? 'active' : ''); ?>">Объекты</a>
            </div>
        </div>
        <!-- Контент страницы -->
        <div class="col-md-10 py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>

<footer class="bg-primary text-white text-center py-3 mt-auto">
    &copy; <?php echo e(date('Y')); ?> eCTN. Все права защищены.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/ispolka/resources/views/layouts/app.blade.php ENDPATH**/ ?>
