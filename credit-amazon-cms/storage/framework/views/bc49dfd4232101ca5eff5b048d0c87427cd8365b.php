<div class="row">
	<table class="table">
		<thead>
			<th>მომწოდებელი</th>
			<th>მარაგი</th>
			<th>წუნდებული</th>
		</thead>
		<tbody>
			<?php $__currentLoopData = $product_suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
				<td><?php echo e($s->supplier_name); ?></td>
				<td><?php echo e($s->quantity); ?></td>
				<td><?php echo e($s->defective); ?></td>
			</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
	</table>
</div>


<h1>ისტორია</h1>
<div class="row" style="margin-top: 50px;">
	<?php echo $__env->make('stocks.product_history_table', ['product_id' => $product_id], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
</div>
