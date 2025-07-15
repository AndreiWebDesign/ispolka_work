<?php $__env->startSection('title', 'Вход'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container d-flex flex-column justify-content-center align-items-center flex-grow-1">
        <form method="POST" action="<?php echo e(route('login')); ?>" class="bg-white p-4 rounded shadow w-100" style="max-width: 400px;">
            <?php echo csrf_field(); ?>
            <h2 class="mb-4 text-center">Вход</h2>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
            </div>
            <div class="mb-4">
                <input type="password" name="password" class="form-control" placeholder="Пароль" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Войти</button>
            <div class="mt-3 text-center">
                <a href="<?php echo e(route('register')); ?>">Нет аккаунта? Зарегистрироваться</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/ispolka/resources/views/auth/login.blade.php ENDPATH**/ ?>