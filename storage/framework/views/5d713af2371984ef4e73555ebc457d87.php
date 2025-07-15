<?php $__env->startSection('title', 'Объект: ' . ($passport->object_name ?? $passport->id)); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <h2 class="mb-3">Объект: <?php echo e($passport->object_name ?? $passport->id); ?></h2>
        <div class="mb-4">
            <a href="<?php echo e(route('acts.create', $passport)); ?>" class="btn btn-success">Создать акт</a>
        </div>

        
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <h4>Список актов</h4>
        <?php if($acts->isEmpty()): ?>
            <div class="alert alert-info">Для этого объекта ещё нет актов.</div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>№ акта</th>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $acts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $act): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($act->act_number); ?></td>
                        <td><?php echo e($act->act_date); ?></td>
                        <td><?php echo e($act->type ?? '-'); ?></td>
                        <td>
                            <a href="<?php echo e(route('acts.pdf', $act->id)); ?>"
                               class="btn btn-outline-primary btn-sm"
                               target="_blank">
                                <i class="bi bi-file-earmark-pdf"></i> Скачать PDF
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/ispolka/resources/views/objects/show.blade.php ENDPATH**/ ?>