<div class="row pt-1 pl-3 pb-3">
	<a href="<?php echo e(route('stock.index')); ?>" class="btn btn-success ml-2">მიღებები</a>
	<a href="<?php echo e(route('stock.restock')); ?>" class="btn btn-success ml-2">ნივთის მიღება</a>
	<a href="<?php echo e(route('stock.return.index')); ?>" class="btn btn-success ml-2">ნივთის დაბრუნება</a>
	<a href="<?php echo e(route('stock.products')); ?>" class="btn btn-success ml-2">მარაგები</a>
	<a href="<?php echo e(route('stock.stock_adjustment')); ?>" class="btn btn-success ml-2">მარაგის კორექტირება</a>
	<a href="<?php echo e(route('stock.stock_correction_log')); ?>" class="btn btn-success ml-2">მარაგის კორექტირების ლოგი</a>
	<a href="<?php echo e(route('stock.error_log')); ?>" class="btn btn-success ml-2">ერორების ლოგი</a>
	<a href="<?php echo e(route('stock.return_log')); ?>" class="btn btn-success ml-2">დაბრუნებების ლოგი</a>
</div>