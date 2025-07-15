<?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

<?php $__env->startSection('content'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <div class="container mt-4" x-data="signForm()">
        <input type="file" accept="application/pdf" x-ref="file" class="form-control mb-3">
        <button class="btn btn-primary" @click="run">Подписать PDF</button>

        <template x-if="link">
            <a :href="link" class="btn btn-success mt-3" target="_blank">Скачать подписанный файл</a>
        </template>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/ispolka/resources/views/sign.blade.php ENDPATH**/ ?>