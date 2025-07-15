<?php $__env->startSection('title', 'Регистрация'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container d-flex flex-column justify-content-center align-items-center flex-grow-1">
        <form method="POST" action="<?php echo e(route('register.post')); ?>" class="bg-white p-4 rounded shadow w-100" style="max-width: 400px;">
            <?php echo csrf_field(); ?>
            <h2 class="mb-4 text-center">Регистрация</h2>

            
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Имя" value="<?php echo e(old('name')); ?>" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo e(old('email')); ?>" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Пароль" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Подтвердите пароль" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Зарегистрироваться</button>
            <div class="mt-3 text-center">
                <a href="<?php echo e(route('login')); ?>">Уже есть аккаунт? Войти</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/ispolka/resources/views/auth/registration.blade.php ENDPATH**/ ?>