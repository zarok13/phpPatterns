<?php $__env->startSection('content'); ?>
	<form target="_blank"  action="<?php echo e(route('report.item.download')); ?>" method="get" id="filter_form">
		<?php echo csrf_field(); ?>
		<style>
			.btn-group .btn {width: 100%;text-align: left;padding: 3px;}
			.btn-group {display: none;}
		</style>
		
		<div class="filter" id="filter_div" style="width: 100%; box-shadow: 0px 0px 25px 5px rgba(8, 16, 23, 0.24); background: transparent; border-radius:5px; padding: 5px;margin-bottom: 10px ">

			<div data-hide="no" style="margin-bottom: 10px;">
				<button type="button" class="btn btn-secondary">თარიღების მიხედვით </button>
				<a target="_blank"  href="http://cms.creditamazon.ge/reports/items/download?k=a&date_from=<?php echo e(\Carbon\Carbon::parse('today midnight')->format('Y-m-d')); ?>" class="btn btn-success" >
					მხოლოდ დღევანდელი
				</a>
				<a target="_blank"  href="http://cms.creditamazon.ge/reports/items/download?k=a&date_from=<?php echo e(\Carbon\Carbon::parse('yesterday midnight')->format('Y-m-d')); ?>&date_to=<?php echo e(\Carbon\Carbon::parse('today midnight')->format('Y-m-d')); ?>" class="btn btn-success" >
					მხოლოდ გუშინდელი
				</a>
			</div>
			
			<div target="_blank"  class="btn-group" id="bydates" style="display: inline-block; column-count: 4;">
				<label class="btn btn-success " style="background:darkseagreen">
					<input type="date" name="date_from" class="form-control" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>"> 
				</label>
				<label class="btn btn-success " style="background:darkseagreen">
					<input type="date" name="date_to" class="form-control" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>"> 
				</label>
			</div>

		</div>
		
		<button type="success" type="submit">გადმოწერა</button>
	</form>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
	<style>
		.card {
			border-radius: 5px !important;
		}
		.expense-table tr td {
			vertical-align: middle;
			text-align: center
		}
	</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>