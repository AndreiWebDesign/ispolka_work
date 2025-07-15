<?php $__env->startSection('title', 'Объекты'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Паспорта объектов</h2>
            <a href="<?php echo e(route('objects.create')); ?>" class="btn btn-success">Создать паспорт объекта</a>
        </div>
        <?php if($passports->isEmpty()): ?>
            <div class="alert alert-info">Нет созданных объектов.</div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Объект</th>
                    <th>Город/Населённый пункт</th>
                    <th>Заказчик</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $passports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $passport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($passport->id); ?></td>
                        <td><?php echo e($passport->object_name ?? '-'); ?></td>
                        <td><?php echo e($passport->city ?? '-'); ?>/<?php echo e($passport->locality ?? '-'); ?></td>
                        <td><?php echo e($passport->customer); ?></td>
                        <td>
                            <a href="<?php echo e(route('objects.show', $passport)); ?>" class="btn btn-primary btn-sm">Открыть</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/ispolka/resources/views/objects/index.blade.php ENDPATH**/ ?>