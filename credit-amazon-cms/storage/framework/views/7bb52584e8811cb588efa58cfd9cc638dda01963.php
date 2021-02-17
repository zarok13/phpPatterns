<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('stocks.stocksmenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
	<?php echo $__env->make('stocks.stock_histories', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style type="text/css">
    .col-md-12 {
        margin: 0;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.newapp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>