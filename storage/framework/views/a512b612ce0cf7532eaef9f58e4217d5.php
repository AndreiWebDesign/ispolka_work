
    <!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <title>Тестирование функционала NCALayer</title>
</head>
<body class="bg-nca">


<?php echo file_get_contents(resource_path('html/original_ncalayer.html')); ?>



<script src="<?php echo e(asset('js/jquery-3.6.0.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.blockUI.js')); ?>"></script>
<script src="<?php echo e(asset('js/ncalayer.js')); ?>"></script>
</body>
</html>
<?php /**PATH /var/www/ispolka/resources/views/ncalayer.blade.php ENDPATH**/ ?>